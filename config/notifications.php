<?php

return [
    'sms' => env('SMS_DRIVER', 'log'),
    'whatsapp' => env('WHATSAPP_DRIVER', 'log'),
    'default_country_code' => env('DEFAULT_COUNTRY_CODE', '233'),
    
    'telegram' => [
        'driver' => env('TELEGRAM_DRIVER', 'log'),
        'bot_token' => env('TELEGRAM_BOT_TOKEN', ''),
    ],
    
    'gekychat' => [
        'driver' => env('GEKYCHAT_DRIVER', 'log'),
        // Platform API is on api subdomain, not chat subdomain
        // Routes are at: api.gekychat.test/platform/oauth/token
        // So api_url should be just the domain (no /api prefix)
        'api_url' => env('GEKYCHAT_API_URL', env('APP_ENV') === 'local' ? 'http://api.gekychat.test' : 'https://api.gekychat.com'),
        'client_id' => env('GEKYCHAT_CLIENT_ID'),
        'client_secret' => env('GEKYCHAT_CLIENT_SECRET'),
        'system_bot_user_id' => (int) env('GEKYCHAT_SYSTEM_BOT_USER_ID', 0),
        // Legacy support (deprecated)
        'api_key' => env('GEKYCHAT_API_KEY', ''),
        'tenant_id' => env('GEKYCHAT_TENANT_ID', ''),
    ],
    
    'email' => [
        'driver' => env('EMAIL_DRIVER', 'log'),
    ],
];
