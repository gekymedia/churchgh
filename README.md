# churchgh – Laravel Overlay (App Code)

This ZIP contains the **application code overlay** for a Laravel 12 project named *churchgh*.
It includes models, controllers, migrations, seeders, routes and Blade views for a church management system:
- Members & Families
- Services (meetings), Attendance
- Giving: Tithes & Offerings
- Events
- Basic Communications (templates & logs)
- Simple Reports dashboard

> Generated: 2025-10-13 10:43:55 UTC

## Quick Setup

1) **Create a fresh Laravel app** (Laravel 12+ recommended):
```bash
composer create-project laravel/laravel churchgh
```

2) **Unzip this overlay** into the new folder and allow overwrite:
```bash
unzip churchgh_overlay.zip -d churchgh/
```

3) **Database** (SQLite default):
```bash
cd churchgh
touch database/database.sqlite
```
Edit `.env` and set:
```
DB_CONNECTION=sqlite
DB_DATABASE=./database/database.sqlite
```

4) **Install dependencies, build assets and key:**
```bash
composer install
php artisan key:generate
npm install
npm run build
```

5) **Migrate & seed:**
```bash
php artisan migrate --seed
```

6) **Serve:**
```bash
php artisan serve
```
Open http://127.0.0.1:8000

> Optional: Install Breeze or your preferred auth stack if you need UI-driven authentication.

## Routes

- `/` – Dashboard (summary cards & quick links)
- `/members` – CRUD members
- `/services` – CRUD services (meeting definitions) & mark attendance
- `/attendances` – attendance records list
- `/givings/tithes` – record & list tithes
- `/givings/offerings` – record & list offerings
- `/events` – plan/manage church events

## Notes
- This overlay avoids vendor files. Use Composer to install the framework.
- Front-end assets are built via Vite (`npm run dev` during development, `npm run build` for production).

## Messaging Drivers

Outbound SMS/WhatsApp deliveries now run through queued jobs. Configure the drivers via `.env`:

```
SMS_DRIVER=log            # or hubtel
WHATSAPP_DRIVER=log       # or meta
DEFAULT_COUNTRY_CODE=233  # converts 020xxxxxxx -> +23320xxxxxxx

# Hubtel
HUBTEL_CLIENT_ID=
HUBTEL_CLIENT_SECRET=
HUBTEL_FROM=ChurchGH

# Meta Cloud API
WA_CLOUD_TOKEN=
WA_CLOUD_PHONE_ID=
```

Start a worker after dispatching notifications:

```bash
php artisan queue:work
```
