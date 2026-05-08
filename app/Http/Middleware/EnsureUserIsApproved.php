<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsApproved
{
    /**
     * Handle an incoming request.
     * Enforces two gates:
     *   1. Email must be verified.
     *   2. Admin must have set status = 'approved'.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Gate 1: Email must be verified
        if (!$user->hasVerifiedEmail()) {
            return redirect()->route('verification.notice')
                ->with('message', 'Please verify your email address before continuing.');
        }

        // Gate 2: Admin must have approved the account
        if ($user->status !== 'approved') {
            Auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')
                ->with('error', 'Your account is pending admin approval. You will be notified by email once approved.');
        }

        return $next($request);
    }
}
