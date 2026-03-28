<?php

namespace App\Http\Controllers;

use App\Mail\ContactFormSubmission;
use App\Models\ContactSubmission;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;

class ContactController extends Controller
{
    public function submit(Request $request): JsonResponse
    {
        // ── 1. Honeypot check ────────────────────────────────────────────
        // 'website' is a hidden field — humans leave it empty, bots fill it
        if ($request->filled('website')) {
            // Silently succeed so bots think they got through
            return response()->json(['success' => true]);
        }

        // ── 2. Rate limiting — max 3 submissions per IP per 10 minutes ───
        $key = 'contact-form:' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 3)) {
            $seconds = RateLimiter::availableIn($key);
            return response()->json([
                'success' => false,
                'message' => "Too many requests. Please try again in {$seconds} seconds.",
            ], 429);
        }
        RateLimiter::hit($key, 600); // 600 seconds = 10 minutes

        // ── 3. Validate ──────────────────────────────────────────────────
        $validated = $request->validate([
            'name'     => ['required', 'string', 'min:2', 'max:100'],
            'company'  => ['nullable', 'string', 'max:100'],
            'email'    => ['required', 'email:rfc,dns', 'max:150'],
            'location' => ['nullable', 'string', 'max:100'],
            'services' => ['nullable', 'array'],
            'services.*' => ['string', 'max:100'],
            'message' => ['nullable', 'string', 'max:2000'],
        ]);

        $data = array_merge($validated, [
            'ip_address' => $request->ip(),
        ]);

        // ── 4. Save to database ──────────────────────────────────────────
        ContactSubmission::create($data);

        // ── 5. Send email ────────────────────────────────────────────────
        Mail::to('reach@thepacmedia.com')
            ->send(new ContactFormSubmission($data));

        return response()->json([
            'success' => true,
            'message' => 'Your briefing request has been received. We\'ll be in touch.',
        ]);
    }
}
