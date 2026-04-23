<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\LetterController;
use App\Http\Controllers\Admin\InboxController;
use App\Http\Controllers\Admin\ChatController;
use App\Http\Controllers\Admin\LogController;
use App\Http\Controllers\Admin\SettingsController;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

// ── Dashboard ──────────────────────────────────────────────────────────
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('admin.dashboard');

// ── Invoices ───────────────────────────────────────────────────────────
Route::prefix('invoices')->name('admin.invoices.')->group(function () {
    Route::get('/',           [InvoiceController::class, 'index'])  ->name('index');
    Route::get('/create',     [InvoiceController::class, 'create']) ->name('create');
    Route::post('/',          [InvoiceController::class, 'store'])  ->name('store');
    Route::get('/{invoice}',  [InvoiceController::class, 'show'])   ->name('show');
    Route::get('/{invoice}/edit',     [InvoiceController::class, 'edit'])   ->name('edit');
    Route::put('/{invoice}',          [InvoiceController::class, 'update']) ->name('update');
    Route::delete('/{invoice}',       [InvoiceController::class, 'destroy'])->name('destroy');

    // Invoice actions
    Route::post('/{invoice}/send',      [InvoiceController::class, 'send'])         ->name('send');
    Route::post('/{invoice}/duplicate', [InvoiceController::class, 'duplicate'])    ->name('duplicate');
    Route::get('/{invoice}/pdf',        [InvoiceController::class, 'pdf'])          ->name('pdf');
    Route::post('/{invoice}/payment',   [InvoiceController::class, 'recordPayment'])->name('payment');

    // ← ADD THIS: renders the PDF blade as plain HTML in the browser (no Browsershot)
    Route::get('/{invoice}/preview',    [InvoiceController::class, 'preview'])      ->name('preview');
});

// ── Clients ────────────────────────────────────────────────────────────
Route::prefix('clients')->name('admin.clients.')->group(function () {
    // 1. Custom routes MUST come first
    Route::get('data', [ClientController::class, 'data'])->name('data');
    Route::patch('{id}/restore', [ClientController::class, 'restore'])->name('restore');

    // 2. Standard CRUD Resource
    // We use an empty string '' because the 'clients' prefix is already in the group
    Route::resource('', ClientController::class)
        ->parameters(['' => 'client']) // Tells Laravel to use {client} as the wildcard name
        ->names([
            'index'   => 'index',
            'create'  => 'create',
            'store'   => 'store',
            'show'    => 'show',
            'edit'    => 'edit',
            'update'  => 'update',
            'destroy' => 'destroy',
        ]);
});

// ── Projects ───────────────────────────────────────────────────────────
Route::prefix('projects')->name('admin.projects.')->group(function () {
    Route::get('/',                 [ProjectController::class, 'index'])  ->name('index');
    Route::get('/create',           [ProjectController::class, 'create']) ->name('create');
    Route::post('/',                [ProjectController::class, 'store'])  ->name('store');
    Route::get('/{project}',        [ProjectController::class, 'show'])   ->name('show');
    Route::get('/{project}/edit',   [ProjectController::class, 'edit'])   ->name('edit');
    Route::put('/{project}',        [ProjectController::class, 'update']) ->name('update');
    Route::delete('/{project}',     [ProjectController::class, 'destroy'])->name('destroy');
});

// ── Letters ────────────────────────────────────────────────────────────
Route::prefix('letters')->name('admin.letters.')->group(function () {
    Route::get('/',                 [LetterController::class, 'index'])  ->name('index');
    Route::get('/create',           [LetterController::class, 'create']) ->name('create');
    Route::post('/',                [LetterController::class, 'store'])  ->name('store');
    Route::get('/{letter}',         [LetterController::class, 'show'])   ->name('show');
    Route::get('/{letter}/edit',    [LetterController::class, 'edit'])   ->name('edit');
    Route::put('/{letter}',         [LetterController::class, 'update']) ->name('update');
    Route::delete('/{letter}',      [LetterController::class, 'destroy'])->name('destroy');
});

// ── Inbox ──────────────────────────────────────────────────────────────
Route::prefix('inbox')->name('admin.inbox.')->group(function () {
    Route::get('/', [InboxController::class, 'index'])->name('index');
});

// ── Chat ───────────────────────────────────────────────────────────────
Route::prefix('chat')->name('admin.chat.')->group(function () {
    Route::get('/', [ChatController::class, 'index'])->name('index');
});

// ── Activity Logs ──────────────────────────────────────────────────────
Route::prefix('logs')->name('admin.logs.')->group(function () {
    Route::get('/', [LogController::class, 'index'])->name('index');
});

// ── Settings ───────────────────────────────────────────────────────────
Route::prefix('settings')->name('admin.settings.')->group(function () {
    Route::get('/',  [SettingsController::class, 'index']) ->name('index');
    Route::put('/',  [SettingsController::class, 'update'])->name('update');
});

// ── Session keepalive ──────────────────────────────────────────────────
Route::post('/ping', fn() => response()->noContent())->name('admin.ping');
