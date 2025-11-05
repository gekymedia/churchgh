<?php

namespace App\Services\Notifications\WhatsApp;

use Illuminate\Support\Facades\Http;

class MetaCloudDriver implements WhatsAppDriverInterface
{
    public function sendText(string $toE164, string $message): array
    {
        $token = env('WA_CLOUD_TOKEN');
        $phoneId = env('WA_CLOUD_PHONE_ID');
        if (!$token || !$phoneId) return ['ok'=>false,'error'=>'Missing WA Cloud credentials'];

        $resp = Http::withToken($token)->post("https://graph.facebook.com/v20.0/{$phoneId}/messages", [
            'messaging_product' => 'whatsapp',
            'to' => $toE164,
            'type' => 'text',
            'text' => ['body' => $message],
        ]);
        return ['ok'=>$resp->ok(),'status'=>$resp->status(),'body'=>$resp->json()];
    }
}
