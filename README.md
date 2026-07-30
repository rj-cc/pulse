# Pulse — Employee Portal

**MVP — ready for internal pilot and content validation**

Pulse is a configurable employee intranet homepage with a Filament CMS backend. Content editors manage branding, announcements, system links, and sidebar widgets through an admin panel — no code changes required for day-to-day updates.

---

## Features

### For employees (public portal)

- Branded homepage with topbar, hero, and footer
- Three main content layouts: carousel, icon grid, and info grid
- Sidebar widgets (quick access, birthdays, help links, and more)
- Detail sheet for rich announcement content
- Live clock and time-of-day greeting
- Scroll-reveal animations

### For content editors (admin panel)

- **Site Settings** — organization name, logo, hero/footer copy, contact info
- **Main Sections** — homepage content blocks with layout-specific item fields
- **Sidebar Sections** — right-column widget panels
- **Theming** — 5 color palettes and 7 font pairings
- **Publishing** — publish toggles with optional schedule windows (`starts_at` / `ends_at`)
- **Demo seeder** — realistic sample content for quick evaluation

---

## Tech Stack

| Layer | Technology |
|-------|------------|
| Backend | Laravel 13, PHP 8.3+ |
| Admin CMS | Filament 5, Livewire 4 |
| UI components | [BlatUI](https://github.com/anousss007/blatui) (shadcn-style Blade components) |
| Styling | Tailwind CSS v4, Alpine.js |
| Build | Vite 8 |
| Testing | Pest 4 |
| Database | MySQL (development) / SQLite in-memory (tests) |

---

## Requirements

- PHP 8.3 or higher
- Composer
- Node.js and npm
- MySQL

---

## Quick Start

### Automated setup

```bash
composer run setup
```

This runs: `composer install`, copies `.env` if missing, generates an app key, runs migrations, installs npm packages, and builds frontend assets.

### Manual setup

```bash
cp .env.example .env

# Create a MySQL database named "pulse", then configure DB_* in .env

composer install
php artisan key:generate
php artisan migrate
php artisan db:seed
npm install
npm run build
```

### Development server

```bash
composer run dev
```

Starts the PHP server, queue listener, and Vite dev server concurrently.

---

## URLs

| Page | URL |
|------|-----|
| Public portal | `/` or `https://pulse.test` (via Herd/Envkit) |
| Admin panel | `/admin` |
| Admin registration | `/admin/register` |

No default admin user is seeded. Register your first account at `/admin/register`, then sign in at `/admin/login`.

---

## Admin Guide

All portal management lives under the **Portal** navigation group in Filament.

### Site Settings

Configure organization branding: name, tagline, logo, topbar contact info, hero copy, footer links, color palette, and font pairing. Changes apply immediately on the public portal.

### Main Sections

Create homepage content blocks. Each section has a layout:

| Layout | Use case |
|--------|----------|
| **Carousel** | Announcements with badges, images, and optional detail modals |
| **Icon grid** | System links and tools with icons |
| **Info grid** | Must-know cards with tags and descriptions |

Add items through the section's relation manager. Items support external URLs, detail modals, icons, images, and scheduled visibility.

### Sidebar Sections

Create right-column widget panels — quick links, avatar lists (e.g. birthdays), help resources, and similar compact content.

### Publishing

Both sections and items have publish toggles. Items can optionally be scheduled with `starts_at` and `ends_at` dates. Unpublished or out-of-window items are hidden from the public portal.

---

## Architecture

```
Content editor → Filament /admin → MySQL → PortalController → Public portal /
```

### Key paths

| Area | Location |
|------|----------|
| Controller | `app/Http/Controllers/PortalController.php` |
| Models | `app/Models/PortalSetting.php`, `PortalSection.php`, `PortalSectionItem.php`, `SidebarSection.php`, `SidebarItem.php` |
| Enums | `app/Enums/PortalSectionLayout.php`, `PortalColorPalette.php`, `PortalFontStyle.php` |
| Public views | `resources/views/portal/` |
| UI components | `resources/views/components/ui/` |
| Admin resources | `app/Filament/Resources/PortalSections/`, `SidebarSections/` |
| Site settings page | `app/Filament/Pages/ManagePortalSettings.php` |
| Frontend JS | `resources/js/portal.js` |
| Demo seeder | `database/seeders/PortalSeeder.php` |

### Data model

```mermaid
erDiagram
    PortalSetting ||--o{ PortalSection : "singleton config"
    PortalSection ||--|{ PortalSectionItem : has many
    SidebarSection ||--|{ SidebarItem : has many
```

- **PortalSetting** — singleton row for site-wide branding and theme
- **PortalSection** — main homepage block (carousel, icon grid, or info grid)
- **PortalSectionItem** — individual card, link, or announcement within a section
- **SidebarSection** — sidebar widget group
- **SidebarItem** — individual sidebar link or avatar entry

---

## Development

```bash
# Run tests
composer test

# Format PHP (modified files only)
vendor/bin/pint --dirty

# Rebuild frontend assets
npm run build

# Frontend hot reload
npm run dev
```

For AI agent and coding conventions, see [AGENTS.md](AGENTS.md).

---

## MVP Status

### What MVP means here

Pulse solves one core problem: employees need a single branded homepage for announcements, system links, and quick info — without developers editing code for every change.

The MVP loop is complete:

1. A content editor brands the portal and publishes content through `/admin`
2. Employees visit `/` and see announcements, system links, and sidebar widgets
3. Day-to-day content updates require no developer involvement

### What's in the MVP

- Site settings (branding, colors, fonts)
- Three main section layouts plus sidebar sections
- Publishing and scheduled visibility
- Detail sheet for rich announcement content
- Demo seeder for quick evaluation

### What's intentionally out of scope for MVP

- Employee login on the public portal
- Admin roles and permissions
- Search, analytics, and notifications
- Production-grade test coverage and CI
- Audit trail population

### Production readiness

Pulse is safe for an **internal pilot** to validate content workflows and portal design. Before org-wide or regulated deployment, complete Phase 1 hardening below.

---

## Possible Enhancements (If Pursued)

These are not required for MVP validation but become relevant once the portal moves from pilot to sustained internal use or wider rollout.

### Phase 1 — Harden for production

- Expand test coverage (Filament CRUD, controller integration, scheduling logic)
- Add authorization policies for portal management
- Populate audit metadata (`created_by` / `updated_by`) on create and update
- Add GitHub Actions CI (Pint + Pest)
- Seed a default admin user for development environments
- Align icon documentation (admin forms use Lucide icon names)

### Phase 2 — Better editor and employee experience

- Draft preview before publishing
- Detail sheet modals for sidebar items
- Portal search across announcements, systems, and info cards
- Admin login link on the public portal footer
- Centralized media library for logos, images, and avatars
- Role-based admin (editor vs. super-admin)

### Phase 3 — Enterprise scale

- Employee authentication on the public portal with personalized content
- Multi-portal / multi-tenant support
- Analytics (link clicks, popular systems, announcement views)
- Notifications (email, Teams, Slack) for new announcements
- Headless content API for mobile apps and integrations
- Content version history and rollback
- Multi-language portal content

---

## License

Pulse is open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).
