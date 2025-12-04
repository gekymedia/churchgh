<?php

namespace App\Support;

class Phone
{
    /**
     * Convert a raw phone string into a sanitized E.164-ish format.
     */
    public static function formatE164(?string $raw): ?string
    {
        if (!$raw) {
            return null;
        }

        $digits = preg_replace('/[^0-9+]/', '', $raw);
        if (!$digits) {
            return null;
        }

        if (str_starts_with($digits, '+')) {
            return $digits;
        }

        $country = ltrim((string) config('notifications.default_country_code', ''), '+');
        if (!$country) {
            return null;
        }

        $digits = ltrim($digits, '0');

        return '+'.$country.$digits;
    }
}


