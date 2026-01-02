<?php

return [
    'hubtel' => [
        'account_number' => env('HUBTEL_ACCOUNT_NUMBER'),
        'client_id' => env('HUBTEL_CLIENT_ID'),
        'client_secret' => env('HUBTEL_CLIENT_SECRET'),
        'from' => env('HUBTEL_FROM', 'ChurchGH'),
    ],

    'paystack' => [
        'public_key' => env('PAYSTACK_PUBLIC_KEY'),
        'secret_key' => env('PAYSTACK_SECRET_KEY'),
    ],
];
