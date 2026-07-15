<?php
// app/Http/Controllers/BrandDiscoveryController.php

namespace App\Http\Controllers;

use App\Jobs\NotifyBrandDiscoverySubmitted;
use App\Models\BrandDiscovery;
use App\Http\Requests\StoreBrandDiscoveryRequest;
use Illuminate\Http\Request;

class BrandDiscoveryController extends Controller
{
    /** Blank/generic form — no token, no prefill. */
    public function show(Request $request)
    {
        $clientToken = $request->query('client');

        return view('brand-discovery.form', [
            'clientToken' => $clientToken,
            'discovery'   => null,
            'linkToken'   => null,
            'isHomePage' => false,
            'pageTitle'  => 'Brand Discovery',
        ]);
    }

    /** Token-based link — prefills known fields, tracks opens, blocks resubmission. */
    public function showByToken(string $token)
    {
        $discovery = BrandDiscovery::where('token', $token)->firstOrFail();

        if ($discovery->isSubmitted()) {
            return view('brand-discovery.already-submitted', compact('discovery'));
        }

        // Only flip sent -> opened once; don't touch it if it's already opened.
        if ($discovery->status === 'sent') {
            $discovery->update(['status' => 'opened', 'opened_at' => now()]);
        }

        return view('brand-discovery.form', [
            'clientToken' => $discovery->client_token,
            'discovery'   => $discovery,
            'linkToken'   => $token,
        ]);
    }

    public function store(StoreBrandDiscoveryRequest $request)
    {
        $data = $request->validated();

        $traits = [];
        foreach (BrandDiscovery::TRAIT_KEYS as $key) {
            $traits[$key] = $data[$key] ?? 0;
            unset($data[$key]);
        }
        $data['traits'] = $traits;
        $data['ip_address']   = $request->ip();
        $data['user_agent']   = substr((string) $request->userAgent(), 0, 255);
        $data['status']       = 'submitted';
        $data['submitted_at'] = now();

        $linkToken = $request->input('token');

        if ($linkToken) {
            // Update the existing shell record rather than creating a duplicate
            $discovery = BrandDiscovery::where('token', $linkToken)
                ->whereNotIn('status', BrandDiscovery::SUBMITTED_STATUSES)
                ->first();

            if (!$discovery) {
                return response()->json([
                    'success' => false,
                    'message' => 'This link has already been used or is invalid.',
                ], 409);
            }

            $discovery->update($data);
        } else {
            unset($data['client_token']);
            $data['client_token'] = $request->input('client_token');
            $discovery = BrandDiscovery::create($data);
        }

        NotifyBrandDiscoverySubmitted::dispatch($discovery);

        return response()->json([
            'success' => true,
            'message' => "Thanks {$discovery->name} — we've received it and will review before our first session.",
        ]);
    }
}
