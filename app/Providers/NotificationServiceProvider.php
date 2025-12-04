<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Notifications\Sms\{
    SmsDriverInterface,
    HubtelSmsDriver,
    LogSmsDriver
};
use App\Services\Notifications\WhatsApp\{
    WhatsAppDriverInterface,
    MetaCloudDriver,
    LogWhatsAppDriver
};

class NotificationServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(SmsDriverInterface::class, function () {
            return match (config('notifications.sms')) {
                'hubtel' => new HubtelSmsDriver(),
                default => new LogSmsDriver(),
            };
        });

        $this->app->bind(WhatsAppDriverInterface::class, function () {
            return match (config('notifications.whatsapp')) {
                'meta' => new MetaCloudDriver(),
                default => new LogWhatsAppDriver(),
            };
        });
    }
}


