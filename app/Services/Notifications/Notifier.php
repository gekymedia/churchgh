<?php

namespace App\Services\Notifications;

use App\Services\Notifications\Sms\{SmsDriverInterface, LogSmsDriver, HubtelSmsDriver};
use App\Services\Notifications\WhatsApp\{WhatsAppDriverInterface, LogWhatsAppDriver, MetaCloudDriver};

class Notifier
{
    protected SmsDriverInterface $sms;
    protected WhatsAppDriverInterface $wa;

    public function __construct()
    {
        $this->sms = match (config('notifications.sms')) {
            'hubtel' => new HubtelSmsDriver(),
            default => new LogSmsDriver(),
        };
        $this->wa = match (config('notifications.whatsapp')) {
            'meta' => new MetaCloudDriver(),
            default => new LogWhatsAppDriver(),
        };
    }
    public function sms(string $to, string $message): array { return $this->sms->send($to, $message); }
    public function whatsapp(string $toE164, string $message): array { return $this->wa->sendText($toE164, $message); }
}
