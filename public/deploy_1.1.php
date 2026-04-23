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
$GITHUB_SECRET = 'kLTfNcDq6TSdk5jD2mx4BB14kU6GVe4mzeS97Uym';
$MANUAL_KEY    = 'updatePacmediaWeb@2026';
$LARAVEL_PATH  = '/home/thepacme/domains/thepacmedia.com/pacmedia';
$PUBLIC_PATH   = '/home/thepacme/domains/thepacmedia.com/public_html';
$LOG_FILE      = $LARAVEL_PATH . '/storage/logs/deployment.log';
$BACKUP_BASE   = '/home/thepacme/backups/pacmedia';
$MAX_BACKUPS   = 5;
$ADMIN_EMAIL   = 'deploy@thepacmedia.com';
$FROM_EMAIL    = 'dev@thepacmedia.com';
$BRANCH        = 'main';

// ── PAT token for Git over HTTPS ──────────────────────────────
// Format: https://TOKEN@github.com/USERNAME/REPO.git
// Replace the value below with your actual PAT remote URL.
// After first successful deploy you can rotate the token — the .git/config on
// the server will keep it until you change it here and re-run setup.
$GIT_REMOTE = 'https://YOUR_PAT_TOKEN@github.com/YOUR_USERNAME/YOUR_REPO.git';

// ── Helpers ───────────────────────────────────────────────────
function logMsg($msg) {
    global $LOG_FILE;
    @mkdir(dirname($LOG_FILE), 0755, true);
    file_put_contents($LOG_FILE, "[" . date('Y-m-d H:i:s') . "] $msg\n", FILE_APPEND);
}

/**
 * Run a shell command, log stdout/stderr, and return the exit code.
 * Pass $mustSucceed = true to throw on non-zero exit (aborts deploy).
 */
function run($cmd, $cwd = '/', $mustSucceed = false) {
    logMsg("→ $cmd");
    $proc = proc_open(
        $cmd,
        [0 => ["pipe","r"], 1 => ["pipe","w"], 2 => ["pipe","w"]],
        $pipes,
        $cwd
    );
    if (!is_resource($proc)) {
        logMsg("❌ Failed to start process");
        if ($mustSucceed) throw new Exception("Failed to start: $cmd");
        return 1;
    }
    fclose($pipes[0]);
    $out  = stream_get_contents($pipes[1]);
    $err  = stream_get_contents($pipes[2]);
    fclose($pipes[1]);
    fclose($pipes[2]);
    $code = proc_close($proc);
    if ($out) logMsg("  out: " . trim($out));
    if ($err) logMsg("  err: " . trim($err));
    if ($mustSucceed && $code !== 0) {
        throw new Exception("Command failed (exit $code): $cmd\n" . trim($err ?: $out));
    }
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

    // ── STEP 0: Git repository bootstrap ─────────────────────
    // If no .git exists on the server, initialize it and point it at the
    // remote. This only runs once; subsequent deploys skip straight to fetch.
    if (!file_exists("$LARAVEL_PATH/.git")) {
        logMsg("⚠️  No .git found — initialising repository on server for the first time");

        run("git -C " . escapeshellarg($LARAVEL_PATH) . " init", '/', true);
        run("git -C " . escapeshellarg($LARAVEL_PATH) . " remote add origin " . escapeshellarg($GIT_REMOTE), '/', true);
        logMsg("✅ Git initialised and remote added");
    } else {
        // Ensure remote URL is up to date (safe to run every time)
        run("git -C " . escapeshellarg($LARAVEL_PATH) . " remote set-url origin " . escapeshellarg($GIT_REMOTE), '/');
    }

    // ── STEP 1: Backup ────────────────────────────────────────
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

    // ── STEP 2: Pull latest code ──────────────────────────────
    // Remove stale lock files that would block git operations
    run('rm -f .git/index.lock .git/config.lock', $LARAVEL_PATH);

    // fetch + reset --hard is safer than git pull:
    // handles diverged history, detached HEAD, and local modifications.
    $fetchCode = run(
        "git -C " . escapeshellarg($LARAVEL_PATH) . " fetch origin $BRANCH 2>&1",
        '/'
    );
    if ($fetchCode !== 0) {
        throw new Exception("git fetch failed (exit $fetchCode) — check PAT token, repo URL, and network access from the server.");
    }

    $resetCode = run(
        "git -C " . escapeshellarg($LARAVEL_PATH) . " reset --hard origin/$BRANCH 2>&1",
        '/'
    );
    if ($resetCode !== 0) {
        throw new Exception("git reset --hard failed (exit $resetCode)");
    }

    // Remove untracked files left over from previous deploys
    run("git -C " . escapeshellarg($LARAVEL_PATH) . " clean -fd 2>&1", '/');

    // Log the commit that is now live on the server
    $currentCommit = trim(shell_exec(
        "git -C " . escapeshellarg($LARAVEL_PATH) . " log --oneline -1 2>&1"
    ));
    logMsg("✅ Code updated → $currentCommit");

    // ── STEP 3: Composer ──────────────────────────────────────
    $composerBin = '';
    foreach (['/usr/local/bin/composer', '/usr/bin/composer', '/opt/cpanel/composer/bin/composer'] as $path) {
        if (file_exists($path)) { $composerBin = $path; break; }
    }
    if ($composerBin) {
        run("HOME=/tmp $composerBin install --no-dev --no-interaction --optimize-autoloader 2>&1", $LARAVEL_PATH);
        run("HOME=/tmp $composerBin dump-autoload --optimize --no-dev 2>&1", $LARAVEL_PATH);
        logMsg("✅ Composer done");
    } else {
        logMsg("⚠️  Composer not found — skipping. vendor/ must be committed to git.");
    }

    // ── STEP 4: Node / image compression ─────────────────────
    $nodeCheck = trim(shell_exec('which node 2>/dev/null'));
    if ($nodeCheck && file_exists("$LARAVEL_PATH/compress.mjs")) {
        $nodeResult = run('node compress.mjs', $LARAVEL_PATH);
        if ($nodeResult === 0) {
            logMsg("✅ Images compressed + LQIP regenerated");
        } else {
            logMsg("⚠️  compress.mjs exited with errors — check output above");
        }
    } else {
        logMsg("⚠️  Skipping image compression — node not found or compress.mjs missing");
    }

    // ── STEP 5: Artisan ───────────────────────────────────────
    run('php artisan down --render="errors::503"', $LARAVEL_PATH);

    // Clear everything first — never cache before clearing.
    foreach (['config:clear', 'cache:clear', 'route:clear', 'view:clear'] as $cmd) {
        run("php artisan $cmd", $LARAVEL_PATH);
    }
    logMsg("✅ Caches cleared");

    run('php artisan migrate --force', $LARAVEL_PATH);
    logMsg("✅ Migrations done");

    // Re-cache config and routes (these are safe — no Blade involved)
    run('php artisan config:cache', $LARAVEL_PATH);
    run('php artisan route:cache', $LARAVEL_PATH);

    // Guard view:cache — only run if all required Blade components are present.
    // A missing component causes view:cache to write a corrupt cache and
    // bring the site down. Skipping it is safe; views compile on-demand instead.
    $requiredComponents = [
        'danger-button',
        'secondary-button',
        'primary-button',
        'nav-link',
        'dropdown',
        'app-layout',
        'guest-layout',
    ];
    $compDir  = "$LARAVEL_PATH/resources/views/components";
    $missing  = [];
    foreach ($requiredComponents as $component) {
        if (!file_exists("$compDir/$component.blade.php")) {
            $missing[] = $component;
        }
    }

    if (!empty($missing)) {
        logMsg("⚠️  Skipping view:cache — missing components: " . implode(', ', $missing));
        logMsg("    Site will run fine but views compile on-demand until this is fixed.");
    } else {
        run('php artisan view:cache', $LARAVEL_PATH);
        logMsg("✅ View cache built");
    }

    run('php artisan up', $LARAVEL_PATH);
    run('php artisan queue:restart', $LARAVEL_PATH);
    logMsg("✅ Artisan done — site is up");

    // ── STEP 6: Sync public/ → public_html/ ──────────────────
    // Back up the custom index.php (contains hard-coded paths for this host)
    $idx    = $PUBLIC_PATH . '/index.php';
    $idxBak = "/tmp/idx_bak_" . time() . ".php";
    if (file_exists($idx)) copy($idx, $idxBak);

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

    // Always restore the customised index.php — never overwrite it
    if (file_exists($idxBak)) {
        copy($idxBak, $idx);
        unlink($idxBak);
    }

    run("chmod -R 755 " . escapeshellarg($PUBLIC_PATH));
    logMsg("✅ Public files synced");

    // ── STEP 7: Permissions ───────────────────────────────────
    run("chmod -R 775 storage bootstrap/cache", $LARAVEL_PATH);
    logMsg("✅ Permissions set");

    logMsg("=== ✅ DEPLOYMENT COMPLETE — $currentCommit ===");

    @mail($ADMIN_EMAIL, "✅ Pacmedia Deployed", "Deployment successful at " . date('Y-m-d H:i:s') . "\nCommit: $currentCommit", "From: $FROM_EMAIL");

    if ($isManual) {
        echo "<!DOCTYPE html><html><body style='font-family:sans-serif;padding:40px'>
            <h2 style='color:#155724'>✅ Deployment complete</h2>
            <p><strong>Commit:</strong> " . htmlspecialchars($currentCommit) . "</p>
            <p>" . date('Y-m-d H:i:s') . "</p>
            <p><a href='?key=$MANUAL_KEY&log=1'>View log</a></p>
        </body></html>";
    } else {
        respond(200, json_encode(['status' => 'deployed', 'time' => date('c'), 'commit' => $currentCommit]));
    }

} catch (Exception $e) {
    run('php artisan up', $LARAVEL_PATH);
    logMsg("❌ DEPLOY FAILED: " . $e->getMessage());
    @mail($ADMIN_EMAIL, "❌ Pacmedia Deploy Failed", $e->getMessage(), "From: $FROM_EMAIL");
    if ($isManual) {
        echo "<!DOCTYPE html><html><body style='font-family:sans-serif;padding:40px'>
            <h2 style='color:#c0392b'>❌ Deployment failed</h2>
            <pre>" . htmlspecialchars($e->getMessage()) . "</pre>
            <p><a href='?key=$MANUAL_KEY&log=1'>View full log</a></p>
        </body></html>";
    } else {
        respond(500, 'Deploy failed — check log');
    }
}
