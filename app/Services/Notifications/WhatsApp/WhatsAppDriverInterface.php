<?php

namespace App\Services\Notifications\WhatsApp;

interface WhatsAppDriverInterface { public function sendText(string $toE164, string $message): array; }
