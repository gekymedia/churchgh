<?php

namespace App\Services\Notifications\Telegram;

use Illuminate\Support\Facades\Log;

class LogTelegramDriver implements TelegramDriverInterface
{
    public function send(string $to, string $message): array
    {
        Log::info('[TELEGRAM:LOG] ' . $to . ' | ' . $message);
        return ['success' => true, 'message' => 'Logged to file'];
    }
}
