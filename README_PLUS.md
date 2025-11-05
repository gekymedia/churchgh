# churchgh – PLUS Overlay (Notifications, PDFs, Roles)

This overlay extends your base *churchgh* app with:
- ✅ SMS & WhatsApp notifications (Hubtel + Meta WhatsApp Cloud API drivers with Log fallbacks)
- ✅ PDF receipts for Tithes & Offerings (Dompdf)
- ✅ Role-based access (middleware + seeder)

Generated: 2025-10-14 03:24:44 UTC

## Install prerequisites

Inside your Laravel app (churchgh):

```bash
composer require barryvdh/laravel-dompdf:^2.0
php artisan vendor:publish --provider="Barryvdh\DomPDF\ServiceProvider"
```

> For authentication, install Breeze (if not already):
```bash
composer require laravel/breeze --dev
php artisan breeze:install blade
npm install && npm run build
php artisan migrate
```

## .env additions

```
# === Hubtel SMS (optional) ===
HUBTEL_ACCOUNT_NUMBER=
HUBTEL_CLIENT_ID=
HUBTEL_CLIENT_SECRET=
HUBTEL_FROM=ChurchGH

# === WhatsApp Cloud API (optional) ===
WA_CLOUD_PHONE_ID=
WA_CLOUD_TOKEN=
WA_CLOUD_FROM=
```

## Kernel middleware alias

Add this to `app/Http/Kernel.php` in `$routeMiddleware`:
```php
'role' => \App\Http\Middleware\EnsureRole::class,
```

## Routes added

- `GET /notifications` – form to send SMS/WhatsApp to a member or broadcast
- `POST /notifications/send` – send message
- `GET /receipts/tithes/<built-in function id>` – PDF for a tithe
- `GET /receipts/offerings/<built-in function id>` – PDF for an offering

## Seeder

Adds an admin user (email: admin@example.com, password: password). Change immediately.
