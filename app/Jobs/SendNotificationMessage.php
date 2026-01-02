<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\Notifications\Notifier;

class SendNotificationMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        protected string $channel,
        protected string $to,
        protected string $message,
        protected ?string $subject = null,
    ) {
    }

    public function handle(Notifier $notifier): void
    {
        match($this->channel) {
            'sms' => $notifier->sms($this->to, $this->message),
            'whatsapp' => $notifier->whatsapp($this->to, $this->message),
            'telegram' => $notifier->telegram($this->to, $this->message),
            'gekychat' => $notifier->gekychat($this->to, $this->message),
            'email' => $notifier->email($this->to, $this->message, $this->subject),
            default => throw new \InvalidArgumentException("Unsupported channel: {$this->channel}"),
        };
    }
}


