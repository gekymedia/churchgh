<?php

namespace App\Services\Notifications\Sms;

use Illuminate\Support\Facades\Log;

class LogSmsDriver implements SmsDriverInterface
{
    public function send(string $to, string $message): array
    {
        Log::info('[SMS:LOG] '.$to.' | '.$message);
        return ['ok'=>true,'driver'=>'log'];
    }
}
