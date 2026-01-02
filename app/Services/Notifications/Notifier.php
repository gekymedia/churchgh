<?php

namespace App\Services\Notifications;

use App\Services\Notifications\Sms\SmsDriverInterface;
use App\Services\Notifications\WhatsApp\WhatsAppDriverInterface;
use App\Services\Notifications\Telegram\TelegramDriverInterface;
use App\Services\Notifications\GekyChat\GekyChatDriverInterface;
use App\Services\Notifications\Email\EmailDriverInterface;

class Notifier
{
    public function __construct(
        protected SmsDriverInterface $sms,
        protected WhatsAppDriverInterface $whatsApp,
        protected TelegramDriverInterface $telegram,
        protected GekyChatDriverInterface $gekychat,
        protected EmailDriverInterface $email,
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

    public function telegram(string $to, string $message): array
    {
        return $this->telegram->send($to, $message);
    }

    public function gekychat(string $to, string $message): array
    {
        return $this->gekychat->send($to, $message);
    }

    public function email(string $to, string $message, ?string $subject = null): array
    {
        return $this->email->send($to, $message, $subject);
    }
}
