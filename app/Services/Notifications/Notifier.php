<?php

namespace App\Services\Notifications;

use App\Services\Notifications\Sms\SmsDriverInterface;
use App\Services\Notifications\WhatsApp\WhatsAppDriverInterface;

class Notifier
{
    public function __construct(
        protected SmsDriverInterface $sms,
        protected WhatsAppDriverInterface $whatsApp,
    ) {
    }

    public function sms(string $to, string $message): array
    {
        return $this->sms->send($to, $message);
    }

    public function whatsapp(string $toE164, string $message): array
    {
        return $this->whatsApp->sendText($toE164, $message);
    }
}
