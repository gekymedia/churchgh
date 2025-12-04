<?php

return [
    'sms' => env('SMS_DRIVER', 'log'),
    'whatsapp' => env('WHATSAPP_DRIVER', 'log'),
    'default_country_code' => env('DEFAULT_COUNTRY_CODE', '233'),
];
