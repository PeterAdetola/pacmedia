<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

/*
|--------------------------------------------------------------------------
| Smart Path Detection
|--------------------------------------------------------------------------
| We check for the 'pacmedia' folder first (Production).
| If not found, we assume standard structure (Local/Dev).
*/
$laravelRoot = is_dir(__DIR__.'/../pacmedia')
    ? __DIR__.'/../pacmedia'
    : __DIR__.'/..';

/*
|--------------------------------------------------------------------------
| Maintenance Mode
|--------------------------------------------------------------------------
*/
if (file_exists($maintenance = $laravelRoot.'/storage/framework/maintenance.php')) {
    require $maintenance;
}

/*
|--------------------------------------------------------------------------
| Register Autoloader & Boot App
|--------------------------------------------------------------------------
*/
require $laravelRoot.'/vendor/autoload.php';

// Capture the App instance from bootstrap/app.php
$app = require_once $laravelRoot.'/bootstrap/app.php';

/*
|--------------------------------------------------------------------------
| Fix Public Path for Production
|--------------------------------------------------------------------------
| This ensures that even when the core is in /pacmedia,
| Laravel knows this specific folder is the 'public' root.
*/
$app->bind('path.public', function() {
    return __DIR__;
});

/*
|--------------------------------------------------------------------------
| Handle Request
|--------------------------------------------------------------------------
*/
$app->handleRequest(Request::capture());
