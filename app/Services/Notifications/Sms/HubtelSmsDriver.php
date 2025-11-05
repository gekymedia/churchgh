<?php

namespace App\Services\Notifications\Sms;

use Illuminate\Support\Facades\Http;

class HubtelSmsDriver implements SmsDriverInterface
{
    public function send(string $to, string $message): array
    {
        $id = env('HUBTEL_CLIENT_ID');
        $secret = env('HUBTEL_CLIENT_SECRET');
        $from = env('HUBTEL_FROM','ChurchGH');
        if (!$id || !$secret) return ['ok'=>false,'error'=>'Missing Hubtel credentials'];

        $resp = Http::withBasicAuth($id, $secret)->post('https://smsc.hubtel.com/v1/messages/send', [
            'From' => $from,
            'To' => $to,
            'Content' => $message,
            'ClientId' => $id,
            'ClientSecret' => $secret,
            'RegisteredDelivery' => 'true',
        ]);
        return ['ok'=>$resp->ok(),'status'=>$resp->status(),'body'=>$resp->json()];
    }
}
