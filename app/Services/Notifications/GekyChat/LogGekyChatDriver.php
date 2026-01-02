<?php

namespace App\Services\Notifications\GekyChat;

use Illuminate\Support\Facades\Log;

class LogGekyChatDriver implements GekyChatDriverInterface
{
    public function send(string $to, string $message): array
    {
        Log::info('[GEKYCHAT:LOG] ' . $to . ' | ' . $message);
        return ['success' => true, 'message' => 'Logged to file'];
    }
}
