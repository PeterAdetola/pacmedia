<?php
/**
 * deploy.php — Pacmedia Webhook Deployment Script
 * Place in: public_html/deploy.php
 * GitHub Webhook URL: https://thepacmedia.com/deploy.php
 */

ini_set('display_errors', 0);
error_reporting(E_ALL);
set_time_limit(300);

// ── Configuration ────────────────────────────────────────────
$GITHUB_SECRET = 'kLTfNcDq6TSdk5jD2mx4BB14kU6GVe4mzeS97Uym';         // set this in GitHub webhook settings
$MANUAL_KEY    = 'updatePacmediaWeb@2026';     // for browser-triggered deploys
$LARAVEL_PATH  = '/home/thepacme/domains/thepacmedia.com/pacmedia';
$PUBLIC_PATH   = '/home/thepacme/domains/thepacmedia.com/public_html';
$LOG_FILE      = $LARAVEL_PATH . '/storage/logs/deployment.log';
$BACKUP_BASE   = '/home/thepacme/backups/pacmedia';
$MAX_BACKUPS   = 5;
$ADMIN_EMAIL   = 'deploy@thepacmedia.com';
$FROM_EMAIL    = 'dev@thepacmedia.com';
$BRANCH        = 'main';

// ── Helpers ───────────────────────────────────────────────────
function logMsg($msg) {
    global $LOG_FILE;
    @mkdir(dirname($LOG_FILE), 0755, true);
    file_put_contents($LOG_FILE, "[" . date('Y-m-d H:i:s') . "] $msg\n", FILE_APPEND);
}

function run($cmd, $cwd = '/') {
    logMsg("→ $cmd");
    $proc = proc_open($cmd, [0 => ["pipe","r"], 1 => ["pipe","w"], 2 => ["pipe","w"]], $pipes, $cwd);
    if (!is_resource($proc)) { logMsg("❌ Failed to start process"); return 1; }
    fclose($pipes[0]);
    $out = stream_get_contents($pipes[1]);
    $err = stream_get_contents($pipes[2]);
    fclose($pipes[1]);
    fclose($pipes[2]);
    $code = proc_close($proc);
    if ($out) logMsg("  out: " . trim($out));
    if ($err) logMsg("  err: " . trim($err));
    return $code;
}

function respond($code, $body) {
    http_response_code($code);
    echo $body;
    exit;
}

// ── View log ──────────────────────────────────────────────────
if (isset($_GET['log'], $_GET['key']) && $_GET['key'] === $MANUAL_KEY) {
    header('Content-Type: text/plain');
    echo file_exists($LOG_FILE) ? file_get_contents($LOG_FILE) : 'No log yet.';
    exit;
}

// ── Authentication ────────────────────────────────────────────
$isManual = false;

if (isset($_GET['key'])) {
    if ($_GET['key'] !== $MANUAL_KEY) respond(403, 'Forbidden');
    $isManual = true;
    logMsg("=== MANUAL DEPLOY TRIGGERED ===");
} else {
    $payload   = file_get_contents('php://input');
    $signature = $_SERVER['HTTP_X_HUB_SIGNATURE_256'] ?? '';
    $expected  = 'sha256=' . hash_hmac('sha256', $payload, $GITHUB_SECRET);
    if (!hash_equals($expected, $signature)) {
        logMsg("❌ Signature mismatch");
        respond(403, 'Forbidden');
    }
    // Only deploy on pushes to main branch
    $data = json_decode($payload, true);
    if (($data['ref'] ?? '') !== "refs/heads/$BRANCH") {
        logMsg("Skipping — not a push to $BRANCH");
        respond(200, 'Skipped');
    }
    logMsg("=== GITHUB WEBHOOK DEPLOY: " . ($data['head_commit']['message'] ?? 'no message') . " ===");
}

// ── Deploy ────────────────────────────────────────────────────
try {
    logMsg("--- Starting deployment ---");

    // 1. Backup
    @mkdir($BACKUP_BASE, 0755, true);
    $backup = $BACKUP_BASE . '/backup_' . date('Ymd_His');
    mkdir($backup, 0755, true);
    run("cp -r " . escapeshellarg($LARAVEL_PATH) . " " . escapeshellarg("$backup/pacmedia"));
    logMsg("✅ Backup: $backup");

    // Clean up old backups
    $old = glob("$BACKUP_BASE/backup_*", GLOB_ONLYDIR);
    rsort($old);
    foreach (array_slice($old, $MAX_BACKUPS) as $dir) {
        run("rm -rf " . escapeshellarg($dir));
        logMsg("🗑 Removed old backup: $dir");
    }

    // 2. Git pull
    run('git fetch --all', $LARAVEL_PATH);
    run("git reset --hard origin/$BRANCH", $LARAVEL_PATH);
    logMsg("✅ Code updated");

    // 3. Composer
    run('HOME=/tmp composer install --no-dev --no-interaction --optimize-autoloader', $LARAVEL_PATH);
    logMsg("✅ Composer done");

    // 4. Artisan
    foreach ([
                 'php artisan down --render="errors::503"',
                 'php artisan config:clear',
                 'php artisan cache:clear',
                 'php artisan view:clear',
                 'php artisan migrate --force',
                 'php artisan config:cache',
                 'php artisan view:cache',
                 'php artisan up',
             ] as $cmd) {
        run($cmd, $LARAVEL_PATH);
    }
    logMsg("✅ Artisan done");

    // 5. Sync public folder → public_html
    //    Back up the server's index.php (it has custom paths)
    $idx = $PUBLIC_PATH . '/index.php';
    $idxBak = "/tmp/idx_bak_" . time() . ".php";
    if (file_exists($idx)) copy($idx, $idxBak);

    // Sync everything except index.php
    $items = array_diff(scandir("$LARAVEL_PATH/public"), ['.', '..', 'index.php']);
    foreach ($items as $item) {
        $src  = "$LARAVEL_PATH/public/$item";
        $dest = "$PUBLIC_PATH/$item";
        if (is_dir($src)) {
            @mkdir($dest, 0755, true);
            run("cp -rf " . escapeshellarg($src) . "/. " . escapeshellarg($dest) . "/");
        } else {
            run("cp -f " . escapeshellarg($src) . " " . escapeshellarg($dest));
        }
    }

    // Restore the customised index.php (never overwrite it)
    if (file_exists($idxBak)) {
        copy($idxBak, $idx);
        unlink($idxBak);
    }

    run("chmod -R 755 " . escapeshellarg($PUBLIC_PATH));
    logMsg("✅ Public files synced");

    // 6. Storage permissions
    run("chmod -R 775 storage bootstrap/cache", $LARAVEL_PATH);
    logMsg("✅ Permissions set");

    logMsg("=== ✅ DEPLOYMENT COMPLETE ===");

    @mail($ADMIN_EMAIL, "✅ Pacmedia Deployed", "Deployment successful at " . date('Y-m-d H:i:s'), "From: $FROM_EMAIL");

    if ($isManual) {
        echo "<!DOCTYPE html><html><body style='font-family:sans-serif;padding:40px'>
            <h2 style='color:#155724'>✅ Deployment complete</h2>
            <p>" . date('Y-m-d H:i:s') . "</p>
            <p><a href='?key=$MANUAL_KEY&log=1'>View log</a></p>
        </body></html>";
    } else {
        respond(200, json_encode(['status' => 'deployed', 'time' => date('c')]));
    }

} catch (Exception $e) {
    run('php artisan up', $LARAVEL_PATH);
    logMsg("❌ DEPLOY FAILED: " . $e->getMessage());
    @mail($ADMIN_EMAIL, "❌ Pacmedia Deploy Failed", $e->getMessage(), "From: $FROM_EMAIL");
    respond(500, 'Deploy failed — check log');
}
