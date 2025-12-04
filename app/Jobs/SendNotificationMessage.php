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
    ) {
    }

    public function handle(Notifier $notifier): void
    {
        if ($this->channel === 'sms') {
            $notifier->sms($this->to, $this->message);
            return;
        }

        $notifier->whatsapp($this->to, $this->message);
    }
}


