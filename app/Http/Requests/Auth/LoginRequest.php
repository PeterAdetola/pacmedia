<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     * Accepts either 'username' (Materialize form) or 'email' (Figtree form).
     */
    public function rules(): array
    {
        // If the request contains 'username', validate that field.
        // Otherwise fall back to validating 'email'.
        if ($this->filled('username')) {
            return [
                'username' => ['required', 'string'],
                'password' => ['required', 'string'],
            ];
        }

        return [
            'email'    => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * Supports login via username or email — whichever the form sends.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        // Determine which field was submitted and build credentials accordingly.
        // Username field: look up the user by username OR email column.
        if ($this->filled('username')) {
            $login    = $this->string('username')->toString();
            $field    = 'username'; // error key shown on the form
            $credentials = [
                'username' => $login,
                'password' => $this->input('password'),
            ];
        } else {
            $login    = $this->string('email')->toString();
            $field    = 'email';
            $credentials = [
                'email'    => $login,
                'password' => $this->input('password'),
            ];
        }

        if (! Auth::attempt($credentials, $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());

            // Throw the error on the correct field so the form displays it.
            throw ValidationException::withMessages([
                $field => trans('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        // Use whichever field is present for the throttle error too.
        $field = $this->filled('username') ? 'username' : 'email';

        throw ValidationException::withMessages([
            $field => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Throttle key based on whichever login field was submitted.
     */
    public function throttleKey(): string
    {
        $identifier = $this->filled('username')
            ? $this->string('username')
            : $this->string('email');

        return Str::transliterate(Str::lower($identifier) . '|' . $this->ip());
    }
}
