<x-guest-materialize-layout
    title="Login"
    body-class="login-bg"
    :page-css="asset('admin/assets/css/pages/login.css')"
>
<style>
    .auth-social-btn {
        width: 3rem;
        height: 3rem;
        border-radius: 30%;
        border: 1px solid #d1d5db;       /* was var(--stroke-elements) */
        background: #f9fafb;             /* was var(--base-tint) */
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        text-decoration: none;
        transition: border-color 0.2s ease, background 0.2s ease;
    }
    .auth-social-btn:hover {
        border-color: #9ca3af;           /* was var(--stroke-controls) */
        background-color: #ebebeb;             /* was var(--base-tint-subtle) */
    }
    .auth-social-btn svg { width: 1.25rem; height: 1.25rem; display: block; filter: grayscale(100)}
</style>
    <div id="login-page" class="row">
        <div class="col s12 m6 l4" style="margin: auto;">

            {{-- Logo --}}
            <div class="flex justify-center" style="width:5em; margin: auto;">
                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                     viewBox="0 0 101.5 101.5" style="enable-background:new 0 0 101.5 101.5;" xml:space="preserve">
                    <defs><style>.cls-1{fill:#1c1c1c;}</style></defs>
                    <path class="cls-1" d="M0,0V92.7H92.7V0ZM44.13,85.55,25.84,68.33V48.91H44.13Zm0-40.42H25.84V24l18.29-4.59ZM66.44,63.74,48.15,66V48.91H66.44Zm0-18.61H48.15V26.91l18.29,2.87Z"/>
                </svg>
            </div>

            <x-auth-card-materialize>

                {{-- Cap --}}
                <x-slot name="cap">
                    <x-auth-session-status :status="session('status')" />
                </x-slot>

                {{-- Form --}}
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="row margin pt-7">
                        <div class="input-field col s12">
                            <i class="material-icons prefix pt-2">person_outline</i>
                            <input id="username" type="text" name="username" value="{{ old('username') }}" required autocomplete="username" />
                            <label for="username" class="center-align">Username</label>
                            <x-input-error :messages="$errors->get('username')" class="red-text" />
                        </div>
                    </div>

                    <div class="row margin">
                        <div class="input-field col s12">
                            <i class="material-icons prefix pt-2">lock_outline</i>
                            <input id="password" type="password" name="password" required autocomplete="current-password" />
                            <label for="password">Password</label>
                            <x-input-error :messages="$errors->get('password')" class="red-text" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col s12 ml-2 mt-1">
                            <p class="ml-2">
                                <label>
                                    <input class="filled-in" name="remember" type="checkbox" />
                                    <span>Remember Me</span>
                                </label>
                            </p>
                        </div>
                    </div>

                    {{-- Actions row: social icons on the left, Log In button on the right --}}
                    <div class="row pl-5 pr-5" style="margin-bottom:0;">
                        <div class="col s12" style="display:flex; align-items:center; justify-content:space-between;">

                            {{-- Social icon buttons --}}
                            <div style="display:flex; gap:0.5em;">

                                {{-- Google --}}
                                <a href="{{ route('auth.social.redirect', 'google') }}"
                                   class="auth-social-btn waves-effect waves-light"
                                   title="Continue with Google"
                                   style="display:flex; align-items:center; justify-content:center;">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" style="width:20px;height:20px;">
                                        <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"/>
                                        <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"/>
                                        <path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"/>
                                        <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"/>
                                    </svg>
                                </a>

                                {{-- LinkedIn --}}
                                <a href="{{ route('auth.social.redirect', 'linkedin') }}"
                                   class="auth-social-btn waves-effect waves-light"
                                   title="Continue with LinkedIn"
                                   style="display:flex; align-items:center; justify-content:center;">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" style="width:20px;height:20px;">
                                        <path fill="#0077B5" d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 0 1-2.063-2.065 2.064 2.064 0 1 1 2.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                    </svg>
                                </a>

                                {{-- GitHub --}}
                                <a href="{{ route('auth.social.redirect', 'github') }}"
                                   class="auth-social-btn waves-effect waves-light"
                                   title="Continue with GitHub"
                                   style="display:flex; align-items:center; justify-content:center;">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" style="width:20px;height:20px;">
                                        <path fill="#1b1f23" d="M12 .297c-6.63 0-12 5.373-12 12 0 5.303 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61C4.422 18.07 3.633 17.7 3.633 17.7c-1.087-.744.084-.729.084-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.417-1.305.76-1.605-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.42.36.81 1.096.81 2.22 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 22.092 24 17.592 24 12.297c0-6.627-5.373-12-12-12"/>
                                    </svg>
                                </a>

                            </div>

                            {{-- Log In button --}}
                            <button class="btn-large waves-effect waves-light" onclick="ShowPreloader()">
                                {{ __('Log in') }}
                            </button>

                        </div>
                    </div>
                </form>

                {{-- Footer: Forgot password + Register links --}}
                <x-slot name="footer">
                    <div class="row" style="margin-bottom:0;">
                        <div class="input-field col s6 m6">
                            @if (Route::has('password.request'))
                                <p class="margin left-align medium-small">
                                    <a href="{{ route('password.request') }}" class="grey-text">Forgot password?</a>
                                </p>
                            @endif
                        </div>
                        <div class="input-field col s6 m6">
                            @if (Route::has('register'))
                                <p class="margin right-align medium-small">
                                    <a href="{{ route('register') }}" class="grey-text">Register Now!</a>
                                </p>
                            @endif
                        </div>
                    </div>
                </x-slot>

            </x-auth-card-materialize>

            <div class="row center">Made with <span style="color:red">&#10084;</span> by Pacmedia Creatives</div>

        </div>
    </div>

</x-guest-materialize-layout>
