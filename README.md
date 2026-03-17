# Pacmedia Laravel Starter Kit

A production-ready Laravel starter kit with two complete auth stacks, social OAuth login, and zero Vite dependency for auth pages. Built by [Pacmedia Creatives](https://pacmedia.com).

---

## What's Included

- **Two auth stacks** — Materialize CSS and plain CSS (Figtree)
- **Social OAuth** — Google, LinkedIn, GitHub via Laravel Socialite
- **Username + Email login** — supports both identifiers
- **No Vite required** — auth pages work without `npm run dev`
- **Modular Blade components** — easy to extend and maintain
- **iOS/Safari safe preloader** — gradient bar animation that works on all devices

---

## Requirements

- PHP 8.1+
- Composer
- MySQL / SQLite
- Node.js (only needed if you extend non-auth frontend features)

---

## Quick Start

### 1. Use This Template

On GitHub, click **"Use this template"** → **"Create a new repository"**, name your project, then clone it:

```bash
git clone git@github.com:PeterAdetola/your-new-project.git
cd your-new-project
```

### 2. Install Dependencies

```bash
composer install
```

### 3. Environment Setup

```bash
cp .env.example .env
php artisan key:generate
```

Open `.env` and configure your database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 4. Run Migrations

```bash
php artisan migrate
```

### 5. Serve the App

```bash
php artisan serve
```

Visit `http://localhost:8000` — your auth system is ready.

---

## File Structure

### Materialize Auth Stack

> Used for the main admin-facing auth pages. Requires Materialize CSS assets in `public/admin/assets/`.

| File | Location |
|---|---|
| Layout | `resources/views/components/guest-materialize-layout.blade.php` |
| Card component | `resources/views/components/auth-card-materialize.blade.php` |
| Login | `resources/views/auth/login.blade.php` |
| Register | `resources/views/auth/register.blade.php` |
| Forgot Password | `resources/views/auth/forgot-password.blade.php` |
| Reset Password | `resources/views/auth/reset-password.blade.php` |
| Verify Email | `resources/views/auth/verify-email.blade.php` |

### Plain CSS Auth Stack (Figtree)

> Self-contained, no framework dependency. All styles live inside `guest.blade.php`.

| File | Location |
|---|---|
| Layout | `resources/views/components/guest.blade.php` |
| Card component | `resources/views/components/auth-card.blade.php` |
| Input label | `resources/views/components/input-label.blade.php` |
| Text input | `resources/views/components/text-input.blade.php` |
| Input error | `resources/views/components/input-error.blade.php` |
| Primary button | `resources/views/components/primary-button.blade.php` |

### Auth Logic

| File | Location |
|---|---|
| Login request (username + email) | `app/Http/Requests/Auth/LoginRequest.php` |
| Social OAuth controller | `app/Http/Controllers/Auth/SocialAuthController.php` |
| Social OAuth routes | `routes/web.php` |

---

## Social OAuth Setup

The app supports login and auto-registration via Google, LinkedIn, and GitHub.

### 1. Install Socialite

```bash
composer require laravel/socialite
```

### 2. Add to `config/services.php`

```php
'google' => [
    'client_id'     => env('GOOGLE_CLIENT_ID'),
    'client_secret' => env('GOOGLE_CLIENT_SECRET'),
    'redirect'      => env('GOOGLE_REDIRECT_URI'),
],

'linkedin-openid' => [
    'client_id'     => env('LINKEDIN_CLIENT_ID'),
    'client_secret' => env('LINKEDIN_CLIENT_SECRET'),
    'redirect'      => env('LINKEDIN_REDIRECT_URI'),
],

'github' => [
    'client_id'     => env('GITHUB_CLIENT_ID'),
    'client_secret' => env('GITHUB_CLIENT_SECRET'),
    'redirect'      => env('GITHUB_REDIRECT_URI'),
],
```

### 3. Add to `.env`

```env
GOOGLE_CLIENT_ID=your-google-client-id
GOOGLE_CLIENT_SECRET=your-google-client-secret
GOOGLE_REDIRECT_URI=http://your-app.test/auth/google/callback

LINKEDIN_CLIENT_ID=your-linkedin-client-id
LINKEDIN_CLIENT_SECRET=your-linkedin-client-secret
LINKEDIN_REDIRECT_URI=http://your-app.test/auth/linkedin/callback

GITHUB_CLIENT_ID=your-github-client-id
GITHUB_CLIENT_SECRET=your-github-client-secret
GITHUB_REDIRECT_URI=http://your-app.test/auth/github/callback
```

### 4. Add to `User` model `$fillable`

```php
protected $fillable = [
    'name', 'username', 'email', 'password',
    'google_id', 'linkedin_id', 'github_id',
];
```

### 5. Getting Credentials

| Provider | Where to get credentials |
|---|---|
| **Google** | [console.cloud.google.com](https://console.cloud.google.com) → APIs & Services → Credentials → OAuth 2.0 Client ID |
| **LinkedIn** | [linkedin.com/developers](https://linkedin.com/developers) → Create App → Auth tab → request `openid`, `profile`, `email` scopes |
| **GitHub** | [github.com/settings/developers](https://github.com/settings/developers) → New OAuth App |

> **Remember** to update all redirect URIs to your production domain when deploying.

---

## How OAuth Works

1. User clicks Google / LinkedIn / GitHub button on login page
2. Redirected to provider for authentication
3. On return, the app checks:
    - **Existing OAuth user** → logged in immediately
    - **Existing email user** → account linked to provider, logged in
    - **New user** → account created automatically (name, email, username auto-filled), logged in
4. Email is marked as verified automatically for OAuth users

> **GitHub note:** GitHub users with a private email will see an error asking them to make their email public in GitHub settings.

---

## Username + Email Login

The app accepts both `username` and `email` as login identifiers. The `LoginRequest.php` detects which field was submitted and handles authentication and error reporting accordingly.

To support username login, ensure your `users` table has the `username` column:

```bash
php artisan migrate
```

Migrations included:
- `add_username_to_users_table`
- `add_social_ids_to_users_table` (adds `google_id`, `linkedin_id`, `github_id`, makes `password` nullable)

---

## Customisation

### Changing colours

The accent colour used throughout the plain CSS stack is `#245624` (dark green). To change it, open `resources/views/components/guest.blade.php` and find/replace `#245624` with your colour.

### Changing card padding

Open `resources/views/components/auth-card-materialize.blade.php`. The three sections are clearly commented:

```html
{{-- Card cap --}}
<div style="padding: 1.25em 2em 0.75em 2em;">

{{-- Card body --}}
<div style="padding: 0 2em 0.5em 2em;">

{{-- Card footer --}}
<div style="padding: 0.5em 2em 0.5em 2em;">
```

### Adding a new auth page

1. Create the blade file in `resources/views/auth/`
2. Extend the appropriate layout:
    - Materialize: `<x-guest-materialize-layout>`
    - Plain CSS: `<x-guest-layout>`
3. Wrap content in the card component:
    - Materialize: `<x-auth-card-materialize>`
    - Plain CSS: `<x-auth-card>`

---

## Preloader

Both stacks include an animated gradient bar that appears on form submit. It is always animating in the background (invisible) and revealed on submit — this pattern fixes the Safari/iOS animation freeze bug.

- **Materialize stack** — Materialize indeterminate progress bar inside `auth-card-materialize.blade.php`
- **Plain CSS stack** — custom gradient bar inside `guest.blade.php`, controlled by JS in the same file

---

## Deployment Checklist

```bash
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

- Update all OAuth redirect URIs in `.env` to production URLs
- Set `APP_ENV=production` and `APP_DEBUG=false`
- Run `php artisan migrate` on the production server

---

## Credits

Built and maintained by **Pacmedia Creatives**  
Made with ❤️ — [thepacmedia.com](https://thepacmedia.com)
