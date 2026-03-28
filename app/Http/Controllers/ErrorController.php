<?php

// ─────────────────────────────────────────────────────────────
// FILE: app/Http/Controllers/ErrorController.php
// ─────────────────────────────────────────────────────────────

namespace App\Http\Controllers;

class ErrorController extends Controller
{
    private array $pages = [
        404 => [
            'name'    => 'Not Found',
            'message' => 'This page doesn\'t exist or has been moved. It happens — even to the best-built systems.',
            'icon'    => 'ph-map-trifold',
        ],
        403 => [
            'name'    => 'Forbidden',
            'message' => 'You don\'t have clearance for this area. If you believe this is an error, reach out directly.',
            'icon'    => 'ph-lock-key',
        ],
        419 => [
            'name'    => 'Session Expired',
            'message' => 'Your session timed out. Refresh the page and try again — it only takes a second.',
            'icon'    => 'ph-clock-countdown',
        ],
        500 => [
            'name'    => 'Server Error',
            'message' => 'Something went wrong on our end. We\'re on it. Try again in a moment.',
            'icon'    => 'ph-warning-diamond',
        ],
        503 => [
            'name'    => 'Maintenance',
            'message' => 'We\'re performing a quick tune-up. Everything will be back online shortly.',
            'icon'    => 'ph-wrench',
        ],
    ];

    public function show(int $code)
    {
        $page = $this->pages[$code] ?? $this->pages[404];

        return response()->view('errors.error', [
            'code'     => $code,
            'name'     => $page['name'],
            'message'  => $page['message'],
            'icon'     => $page['icon'],
            'showBack' => $code !== 503,
        ], $code);
    }
}

