<?php

namespace App\Services\Notifications\GekyChat;

interface GekyChatDriverInterface
{
    public function send(string $to, string $message): array;
}
