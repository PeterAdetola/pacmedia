<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\LlmsFullController;
use App\Http\Controllers\BrandDiscoveryController;

// ── Llms Controller ────────────────────────────────
Route::get('/llms-full.txt', [LlmsFullController::class, 'index']);
Route::get('/llms-works.txt', [LlmsFullController::class, 'works']);

// ── Admin Routes (auth + verified + approved) ────────────────────────────────
Route::middleware(['auth', 'verified', 'approved'])->prefix('admin')->group(base_path('routes/admin.php'));

Route::get('/error/{code}', function ($code) {
    return app(\App\Http\Controllers\ErrorController::class)->show((int) $code);
})->where('code', '[0-9]+');

Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);

Route::get('/faqs', [App\Http\Controllers\FaqController::class, 'index'])->name('faqs');

// ── Single dynamic route (resolves all four slugs) ──────────────────────────
Route::get('/services/{slug}', [ServiceController::class, 'show'])
    ->name('service.show')
    ->where('slug', 'brand-architecture|interface-craftsmanship|performance-engineering|intelligent-automation');

// ── Named aliases (slug pre-bound) ───────────────────────────────────────────
Route::get('/services/brand-architecture', [ServiceController::class, 'show'])
    ->defaults('slug', 'brand-architecture')
    ->name('service.brand');

Route::get('/services/interface-craftsmanship', [ServiceController::class, 'show'])
    ->defaults('slug', 'interface-craftsmanship')
    ->name('service.interface');

Route::get('/services/performance-engineering', [ServiceController::class, 'show'])
    ->defaults('slug', 'performance-engineering')
    ->name('service.engineering');

Route::get('/services/intelligent-automation', [ServiceController::class, 'show'])
    ->defaults('slug', 'intelligent-automation')
    ->name('service.automation');

// ── Portfolio Controller ───────────────────────────────────────────────────────────────

// Portfolio detail — slug maps to a .md file
Route::get('/work/{slug}', [PortfolioController::class, 'show'])->name('portfolio.show');

// ── Legal Pages ───────────────────────────────────────────────────────────────
Route::get('/terms', [App\Http\Controllers\LegalController::class, 'terms'])->name('terms');
Route::get('/privacy', [App\Http\Controllers\LegalController::class, 'privacy'])->name('privacy');

// ── Contact Form ──────────────────────────────────────────────────────────────
Route::post('/contact', [App\Http\Controllers\ContactController::class, 'submit'])
    ->name('contact.submit')
    ->middleware('throttle:6,1');

Route::get('/brand-discovery', [BrandDiscoveryController::class, 'show'])
    ->name('brand-discovery.show');

Route::post('/brand-discovery/submit', [BrandDiscoveryController::class, 'store'])
    ->middleware('throttle:6,1') // basic spam guard: 6 submits/min per IP
    ->name('brand-discovery.submit');

// ── Brand Discovery ──────────────────────────────────────────────────────────────
Route::get('/brand-discovery', [BrandDiscoveryController::class, 'show'])
    ->name('brand-discovery.show');

// Token-based prefilled link
Route::get('/brand-discovery/link/{token}', [BrandDiscoveryController::class, 'showByToken'])
    ->name('brand-discovery.show-token');

Route::post('/brand-discovery/submit', [BrandDiscoveryController::class, 'store'])
    ->middleware('throttle:6,1')
    ->name('brand-discovery.submit');

// ── Dashboard (auth + verified + approved) ────────────────────────────────────
Route::get('/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'verified', 'approved'])->name('dashboard');

// ── Profile ───────────────────────────────────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ── Social Auth ───────────────────────────────────────────────────────────────
Route::get('/auth/{provider}', [SocialAuthController::class, 'redirect'])
    ->name('auth.social.redirect')
    ->where('provider', 'google|linkedin|github');

Route::get('/auth/{provider}/callback', [SocialAuthController::class, 'callback']);


// ── Content for LLMs ───────────────────────────────────────────────────────────────

Route::get('/content', function () {
    $sections = [];

    // Grab ALL .md files directly in resources/markdown/
    $rootFiles = glob(resource_path('markdown/*.md'));
    foreach ($rootFiles as $file) {
        $slug    = pathinfo($file, PATHINFO_FILENAME);
        $content = file_get_contents($file);
        $sections[] = "# [{$slug}]\n\n" . $content;
    }

    // Grab ALL portfolio works in resources/markdown/works/
    $works = glob(resource_path('markdown/works/*.md'));
    foreach ($works as $file) {
        $slug    = pathinfo($file, PATHINFO_FILENAME);
        $content = file_get_contents($file);
        $sections[] = "# [work: {$slug}]\n\n" . $content;
    }

    return response(implode("\n\n---\n\n", $sections), 200, [
        'Content-Type' => 'text/plain; charset=utf-8',
    ]);
});

// Individual work files
Route::get('/content/works/{slug}.md', function ($slug) {
    $path = resource_path("markdown/works/{$slug}.md");
    abort_if(!file_exists($path), 404);

    return response(file_get_contents($path), 200, [
        'Content-Type' => 'text/plain; charset=utf-8',
    ]);
});

// Individual root markdown files
Route::get('/content/{slug}.md', function ($slug) {
    $path = resource_path("markdown/{$slug}.md");
    abort_if(!file_exists($path), 404);

    return response(file_get_contents($path), 200, [
        'Content-Type' => 'text/plain; charset=utf-8',
    ]);
});

// llms.txt — full index
Route::get('/llms.txt', function () {
    $lines = [
        "# Pacmedia Creatives",
        "> Tactical digital studio specializing in brand identity and digital infrastructure.",
        "",
        "## Full Content (all pages aggregated)",
        "- [All Content](https://thepacmedia.com/content.md)",
        "",
        "## Pages",
    ];

    $rootFiles = glob(resource_path('markdown/*.md'));
    foreach ($rootFiles as $file) {
        $slug    = pathinfo($file, PATHINFO_FILENAME);
        $lines[] = "- [{$slug}](https://thepacmedia.com/content/{$slug}.md)";
    }

    $lines[] = "";
    $lines[] = "## Portfolio Works";

    $works = glob(resource_path('markdown/works/*.md'));
    foreach ($works as $file) {
        $slug    = pathinfo($file, PATHINFO_FILENAME);
        $lines[] = "- [{$slug}](https://thepacmedia.com/content/works/{$slug}.md)";
    }

    return response(implode("\n", $lines), 200, [
        'Content-Type' => 'text/plain; charset=utf-8',
    ]);
});

// ── Debug routes ──────────────────────────────────────────────────────────────
Route::get('/system-check', function() {
    return [
        'opcache' => function_exists('opcache_get_status') ? 'Enabled' : 'Disabled',
        'queue_count' => DB::table('jobs')->count(),
        'last_log' => file_exists(storage_path('logs/laravel.log')) ? date('Y-m-d H:i:s', filemtime(storage_path('logs/laravel.log'))) : 'N/A'
    ];
})->middleware('auth.admin');

Route::get('/clear-cache', function () {
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    return response()->json(['done' => true]);
});

Route::get('/show-deploy-log', function () {
    $log = '/home/thepacme/domains/thepacmedia.com/pacmedia/storage/logs/deployment.log';
    $lines = file($log);
    $last200 = array_slice($lines, -200);
    return response('<pre>' . implode('', $last200) . '</pre>');
});

Route::get('/deploy/{token}', function (string $token) {
    if ($token !== env('DEPLOY_TOKEN')) {
        abort(403);
    }

    $base = base_path();
    $output = shell_exec("cd {$base} && php artisan route:clear 2>&1");
    $output .= shell_exec("cd {$base} && php artisan config:clear 2>&1");
    $output .= shell_exec("cd {$base} && git pull origin main 2>&1");
    $output .= shell_exec("cd {$base} && php artisan migrate --force 2>&1");
    $output .= shell_exec("cd {$base} && php artisan optimize 2>&1");

    return '<pre>' . $output . '</pre>';
})->middleware('throttle:3,1');


require __DIR__.'/auth.php';
