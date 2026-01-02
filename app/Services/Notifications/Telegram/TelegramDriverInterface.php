<?php

namespace App\Services\Notifications\Telegram;

interface TelegramDriverInterface
{
    public function send(string $to, string $message): array;
}
