<?php

namespace App\Services\Notifications\Email;

use Illuminate\Support\Facades\Log;

class LogEmailDriver implements EmailDriverInterface
{
    public function send(string $to, string $message, ?string $subject = null): array
    {
        Log::info('[EMAIL:LOG] To: ' . $to . ' | Subject: ' . ($subject ?? 'No Subject') . ' | ' . $message);
        return ['success' => true, 'message' => 'Logged to file'];
    }
}
