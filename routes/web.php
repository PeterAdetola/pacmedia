<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\Auth\SocialAuthController;

//Route::get('/', function () {
//    return view('index');
//});

Route::middleware(['auth', 'verified'])->prefix('admin')->group(base_path('routes/admin.php'));

Route::get('/error/{code}', function ($code) {
    return app(\App\Http\Controllers\ErrorController::class)->show((int) $code);
})->where('code', '[0-9]+');

Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);

Route::get('/faqs', [App\Http\Controllers\FaqController::class, 'index'])->name('faqs');

// ── Single dynamic route (resolves all four slugs) ──────────────────────────
Route::get('/services/{slug}', [ServiceController::class, 'show'])
    ->name('service.show')
    ->where('slug', 'brand-architecture|interface-craftsmanship|performance-engineering|intelligent-automation');


// ── Primary dynamic route ────────────────────────────────────────────────────
Route::get('/services/{slug}', [ServiceController::class, 'show'])
    ->name('service.show')
    ->where('slug', 'brand-architecture|interface-craftsmanship|performance-engineering|intelligent-automation');


// ── Named aliases (slug pre-bound — no {slug} wildcard needed in URL) ────────
// These resolve correctly because ->defaults() injects the slug value before
// the controller receives it, bypassing the route parameter entirely.

Route::get('/services/brand-architecture',    [ServiceController::class, 'show'])
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

// ── Legal Pages ───────────────────────────────────────────────
// Add these two lines to your routes/web.php

Route::get('/terms', [App\Http\Controllers\LegalController::class, 'terms'])
    ->name('terms');

Route::get('/privacy', [App\Http\Controllers\LegalController::class, 'privacy'])
    ->name('privacy');

// ── Contact Form ─────────────────────────────────────────────────────────────
Route::post('/contact', [App\Http\Controllers\ContactController::class, 'submit'])
    ->name('contact.submit')
    ->middleware('throttle:6,1'); // extra layer: 6 requests per minute via Laravel's built-in throttle





Route::get('/pending-approval', function () {
    return view('auth.verification-notice');
})->middleware(['auth'])->name('verification.notice');

Route::get('/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Redirect to provider (Google / LinkedIn / GitHub)
Route::get('/auth/{provider}', [SocialAuthController::class, 'redirect'])
    ->name('auth.social.redirect')
    ->where('provider', 'google|linkedin|github');

// Provider redirects back here after authentication
Route::get('/auth/{provider}/callback', [SocialAuthController::class, 'callback']);


// ── Debug routes ─────────────────────────────────────────────────────────────

Route::get('/show-deploy-log', function () {
    $log = '/home/thepacme/domains/thepacmedia.com/pacmedia/storage/logs/deployment.log';
    $lines = file($log);
    $last200 = array_slice($lines, -200);
    return response('<pre>' . implode('', $last200) . '</pre>');
});

Route::get('/server-check', function () {
    dd('route is fresh');
});


Route::get('/browsershot-check', function () {
    $checks = [
        'node'      => trim(shell_exec('which node 2>/dev/null') ?: 'not found'),
        'chromium'  => trim(shell_exec('which chromium-browser 2>/dev/null') ?: 'not found'),
        'chrome'    => trim(shell_exec('which google-chrome 2>/dev/null') ?: 'not found'),
        'puppeteer' => file_exists(base_path('node_modules/puppeteer')) ? 'installed' : 'missing',
    ];
    return response()->json($checks);
});
Route::get('/server-check', function () {
    return response()->json([
        'composer' => trim(shell_exec('which composer 2>/dev/null') ?: shell_exec('find /usr /opt /home -name "composer" -type f 2>/dev/null | head -1')),
        'php'      => trim(shell_exec('which php')),
        'php_ver'  => PHP_VERSION,
    ]);
});


require __DIR__.'/auth.php';
