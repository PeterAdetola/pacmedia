<x-guest-materialize-layout
    title="Register"
    body-class="login-bg"
    :page-css="asset('admin/assets/css/pages/login.css')"
>

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

                <form method="POST" action="{{ route('register') }}" class="login-form">
                    @csrf

                    <div class="row margin">
                        <div class="input-field col s12">
                            <i class="material-icons prefix pt-2">account_circle</i>
                            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus />
                            <label for="name" class="center-align">Name</label>
                        </div>
                        @error('name')
                        <small class="red-text">{{ $message }}*</small>
                        @enderror
                    </div>

                    <div class="row margin">
                        <div class="input-field col s12">
                            <i class="material-icons prefix pt-2">person_outline</i>
                            <input id="username" type="text" name="username" value="{{ old('username') }}" required autocomplete="username" />
                            <label for="username" class="center-align">Username</label>
                        </div>
                        @error('username')
                        <small class="red-text">{{ $message }}*</small>
                        @enderror
                    </div>

                    <div class="row margin">
                        <div class="input-field col s12">
                            <i class="material-icons prefix pt-2">mail_outline</i>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" />
                            <label for="email">Email</label>
                        </div>
                        @error('email')
                        <small class="red-text">{{ $message }}*</small>
                        @enderror
                    </div>

                    <div class="row margin">
                        <div class="input-field col s12">
                            <i class="material-icons prefix pt-2">lock_outline</i>
                            <input id="password" type="password" name="password" required autocomplete="new-password" />
                            <label for="password">Password</label>
                        </div>
                        @error('password')
                        <small class="red-text">{{ $message }}*</small>
                        @enderror
                    </div>

                    <div class="row margin">
                        <div class="input-field col s12">
                            <i class="material-icons prefix pt-2">lock_outline</i>
                            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" />
                            <label for="password_confirmation">Confirm Password</label>
                        </div>
                        @error('password_confirmation')
                        <small class="red-text">{{ $message }}*</small>
                        @enderror
                    </div>

                    <div class="row pl-5 pr-5">
                        <div class="input-field right">
                            <button class="btn-large waves-effect waves-light" onclick="ShowPreloader()">
                                {{ __('Register') }}
                            </button>
                        </div>
                    </div>

                </form>

                {{-- Footer --}}
                <x-slot name="footer">
                    <div class="row" style="margin-bottom:0;">
                        <div class="input-field col s12">
                            <p class="margin medium-small">
                                <a href="{{ route('login') }}">Already have an account? Login</a>
                            </p>
                            <p class="medium-small grey-text" style="margin-top:0.25em;">
                                Have a Google, LinkedIn or GitHub account?
                                <a href="{{ route('login') }}" class="grey-text" style="text-decoration:underline;">Sign in there instead</a>
                                — we'll create your account automatically.
                            </p>
                        </div>
                    </div>
                </x-slot>

            </x-auth-card-materialize>

        </div>
    </div>

</x-guest-materialize-layout>
