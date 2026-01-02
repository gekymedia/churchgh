<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;
use App\Models\Quote;

/**
 * Class DailyQuoteNotification
 *
 * Sends a devotional quote to users via the database (in‑app) and,
 * optionally, via email if the user has opted in. The notification carries
 * the title, scripture and message from the Quote model.
 */
class DailyQuoteNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(protected Quote $quote)
    {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array<int, string>
     */
    public function via(mixed $notifiable): array
    {
        $channels = ['database'];
        // Send email only if user has opted in
        if (method_exists($notifiable, 'receive_quote_email') && $notifiable->receive_quote_email) {
            if ($notifiable->email) {
                $channels[] = 'mail';
            }
        }
        return $channels;
    }

    /**
     * Get the array representation of the notification for database storage.
     */
    public function toArray(mixed $notifiable): array
    {
        return [
            'title'     => $this->quote->title,
            'scripture' => $this->quote->scripture,
            'message'   => $this->quote->message,
            'delivery_date' => $this->quote->delivery_date->toDateString(),
        ];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(mixed $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Today’s Word')
            ->greeting('Greetings!')
            ->line($this->quote->title)
            ->line($this->quote->scripture)
            ->line($this->quote->message)
            ->line('Be blessed!');
    }
}