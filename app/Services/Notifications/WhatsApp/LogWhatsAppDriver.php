<?php

namespace App\Services\Notifications\WhatsApp;

use Illuminate\Support\Facades\Log;

class LogWhatsAppDriver implements WhatsAppDriverInterface
{
    public function sendText(string $toE164, string $message): array
    {
        \Log::info('[WA:LOG] '.$toE164.' | '.$message);
        return ['ok'=>true,'driver'=>'log'];
    }
}
