# Pacmedia

**Forging Identity. Engineering Digital Infrastructure.**

Pacmedia is a brand and digital studio operating from Lagos, Nigeria — building visual identity systems and precision-engineered digital infrastructure for ambitious businesses worldwide. We work selectively, combining strategic brand thinking with full-stack web development and intelligent automation.

---

## What This Repository Contains

This repository contains the source code for [thepacmedia.com](https://thepacmedia.com) — the studio's primary web presence, client portal, and service delivery platform.

---

## Tech Stack

| Layer | Technology |
|---|---|
| Framework | Laravel 12 (PHP) |
| Frontend | Blade Templates, Bootstrap Grid, GSAP, SplitType |
| Styling | Custom CSS with CSS Variables (light/dark mode) |
| Icons | Phosphor Icons |
| Animations | GSAP ScrollTrigger, imagesLoaded |
| Calendar | Cal.com Embed |
| Email | Laravel Mail with custom Blade templates |
| Database | MySQL |
| Deployment | Production server with HTTPS |

---

## Project Structure

```
pacmedia/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── HomeController.php          # Homepage — all sections
│   │       ├── ServiceController.php       # Service detail pages
│   │       ├── FaqController.php           # FAQ page
│   │       ├── LegalController.php         # Terms & Privacy pages
│   │       └── ErrorController.php         # Custom error pages
├── resources/
│   ├── views/
│   │   ├── layouts/
│   │   │   ├── app.blade.php               # Main layout
│   │   │   ├── navbar.blade.php            # Homepage navbar
│   │   │   ├── navbar-inner.blade.php      # Inner page navbar
│   │   │   ├── navbar-mobile.blade.php     # Mobile menu
│   │   │   └── footer.blade.php            # Footer
│   │   ├── components/
│   │   │   ├── cookie-consent.blade.php    # Cookie banner
│   │   │   └── engagement-modal.blade.php  # Contact modal
│   │   ├── emails/
│   │   │   └── base.blade.php              # Transactional email template
│   │   ├── errors/
│   │   │   └── error.blade.php             # Custom error pages (404, 403, 419, 500, 503)
│   │   ├── index.blade.php                 # Homepage
│   │   ├── service-detail.blade.php        # Service detail page
│   │   ├── faqs.blade.php                  # Full FAQ page
│   │   └── legal.blade.php                 # Terms & Privacy page
│   ├── markdown/
│   │   ├── hero.md                         # Hero section content
│   │   ├── about.md                        # About section content
│   │   ├── process.md                      # Process section content
│   │   ├── services.md                     # Services cards content
│   │   ├── faqs.md                         # Homepage FAQ content
│   │   ├── faqs_page.md                    # Full FAQ page content
│   │   ├── contact.md                      # Contact section content
│   │   ├── service_brand-architecture.md
│   │   ├── service_interface-craftsmanship.md
│   │   ├── service_performance-engineering.md
│   │   ├── service_intelligent-automation.md
│   │   ├── terms-and-conditions.md
│   │   └── privacy-policy.md
│   └── css/
│       ├── main.css                        # Template base styles
│       └── custom.css                      # Pacmedia overrides & components
├── public/
│   ├── css/
│   ├── js/
│   │   ├── app.js                          # Main JS — GSAP, loader, interactions
│   │   └── modal.js                        # Engagement modal
│   └── img/
│       ├── services/
│       ├── backgrounds/
│       ├── logo/
│       └── favicon/
└── routes/
    └── web.php
```

---

## Key Features

### Content Architecture
All page content is managed through Markdown files in `resources/markdown/` — no database queries needed for static content. Each section (hero, about, process, services, FAQs, legal) is parsed by its respective controller and passed to Blade as structured data.

### Client Portal *(in development)*
A private client portal is under active development. It will provide:
- Magic link authentication (no passwords)
- Brand Intelligence Brief — structured discovery form with personality sliders
- Project dashboard with real-time phase tracking
- Deliverables section with file organisation by phase
- In-portal commenting and approval system
- Automated email notifications on milestone changes

### Service Pages
Four dedicated service pages — Visual Brand Architecture, Interface Craftsmanship, Performance Engineering, and Intelligent Automation — each parsed from individual Markdown files with structured sections: headline, body, deliverables list, and a 3-step process breakdown.

### Engagement Modal
A two-step modal triggered from multiple entry points across the site: submit a briefing form (scrolls to contact section) or schedule a strategy call directly via Cal.com inline embed. Fully wired to the site's colour scheme including theme-aware Cal.com styling.

### Error Pages
Custom branded error pages for 404, 403, 419, 500, and 503 — standalone HTML documents with the Pacmedia logo, colour switcher, and contextual messaging. Registered via Laravel 12's `bootstrap/app.php` exception handler.

### Light / Dark Mode
Full light and dark mode support via CSS custom properties. Theme preference is stored in `localStorage` and applied on load. Cal.com embed, error pages, email templates, and cookie banner all respond to the active theme.

---

## Getting Started

### Requirements
- PHP 8.2+
- Composer
- Node.js & npm
- MySQL

### Installation

```bash
# Clone the repository
git clone https://github.com/yourusername/pacmedia.git
cd pacmedia

# Install PHP dependencies
composer install

# Install JS dependencies
npm install

# Copy environment file and configure
cp .env.example .env
php artisan key:generate

# Set up database
php artisan migrate

# Build assets
npm run build

# Start local server
php artisan serve
```

### Environment Variables

Key variables to configure in `.env`:

```env
APP_NAME=Pacmedia
APP_URL=https://thepacmedia.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pacmedia
DB_USERNAME=
DB_PASSWORD=

MAIL_MAILER=smtp
MAIL_HOST=
MAIL_PORT=587
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_FROM_ADDRESS=reach@thepacmedia.com
MAIL_FROM_NAME="Pacmedia"
```

---

## Content Management

All static content is edited through Markdown files — no admin panel required for copy updates.

**To update a section:** edit the corresponding `.md` file in `resources/markdown/`, commit, and deploy. The controller parses it on every request.

**Markdown format conventions used across this project:**

```
---          Section separator
# Heading    H1 title
## Heading   H2 subtitle or section group
### Heading  H3 subsection
- Item       Bullet list item
> Text       Note / aside block
key: value   Metadata (icon, image, slug)
```

---

## Services

| Service | Slug |
|---|---|
| Visual Brand Architecture | `/services/brand-architecture` |
| Interface Craftsmanship | `/services/interface-craftsmanship` |
| Performance Engineering | `/services/performance-engineering` |
| Intelligent Automation | `/services/intelligent-automation` |

---

## Legal Pages

| Page | Route |
|---|---|
| Terms & Conditions | `/terms` |
| Privacy Policy | `/privacy` |

---

## Design System

Pacmedia uses a token-based CSS variable system defined in `main.css`:

```css
--base              Page background
--base-tint         Subtle elevated surface
--base-shade        Deeper surface / shadow
--stroke-elements   Borders and dividers
--t-bright          Primary text
--t-medium          Secondary text
--t-muted           Tertiary / label text
--neutral-bright    Button fill (inverts per scheme)
--_radius           Standard border radius (2rem)
--_radius-s         Small border radius (1rem)
```

All components respect both `[color-scheme="light"]` and `[color-scheme="dark"]` attribute selectors applied to `:root`.

---

## Deployment

The site is deployed to a production server. On each deployment:

```bash
composer install --no-dev --optimize-autoloader
php artisan config:cache
php artisan route:cache
php artisan view:cache
npm run build
```

---

## Studio

**Pacmedia** — Lagos, Nigeria
[thepacmedia.com](https://thepacmedia.com) · [reach@thepacmedia.com](mailto:reach@thepacmedia.com)

*Forging Identity. Engineering Digital Infrastructure.*
