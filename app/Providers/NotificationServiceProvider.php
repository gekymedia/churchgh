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
use App\Services\Notifications\Telegram\{
    TelegramDriverInterface,
    TelegramBotDriver,
    LogTelegramDriver
};
use App\Services\Notifications\GekyChat\{
    GekyChatDriverInterface,
    GekyChatApiDriver,
    LogGekyChatDriver
};
use App\Services\Notifications\Email\{
    EmailDriverInterface,
    LaravelMailDriver,
    LogEmailDriver
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

        $this->app->bind(TelegramDriverInterface::class, function () {
            return match (config('notifications.telegram.driver', 'log')) {
                'telegram' => new TelegramBotDriver(),
                default => new LogTelegramDriver(),
            };
        });

        $this->app->bind(GekyChatDriverInterface::class, function () {
            return match (config('notifications.gekychat.driver', 'log')) {
                'api' => new GekyChatApiDriver(),
                default => new LogGekyChatDriver(),
            };
        });

        $this->app->bind(EmailDriverInterface::class, function () {
            return match (config('notifications.email.driver', 'log')) {
                'mail' => new LaravelMailDriver(),
                default => new LogEmailDriver(),
            };
        });
    }
}


