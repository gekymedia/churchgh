<?php

namespace App\Services\Notifications\Telegram;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramBotDriver implements TelegramDriverInterface
{
    protected string $botToken;
    protected string $apiUrl = 'https://api.telegram.org/bot';

    public function __construct()
    {
        $this->botToken = config('notifications.telegram.bot_token', '');
    }

    public function send(string $to, string $message): array
    {
        if (empty($this->botToken)) {
            Log::error('[TELEGRAM] Bot token not configured');
            return ['success' => false, 'error' => 'Telegram bot token not configured'];
        }

        try {
            $response = Http::post("{$this->apiUrl}{$this->botToken}/sendMessage", [
                'chat_id' => $to,
                'text' => $message,
                'parse_mode' => 'HTML',
            ]);

            if ($response->successful() && $response->json('ok')) {
                return ['success' => true, 'message_id' => $response->json('result.message_id')];
            }

            Log::error('[TELEGRAM] Send failed', ['response' => $response->json()]);
            return ['success' => false, 'error' => $response->json('description', 'Unknown error')];
        } catch (\Exception $e) {
            Log::error('[TELEGRAM] Exception', ['error' => $e->getMessage()]);
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
}
