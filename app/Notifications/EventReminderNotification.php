<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Event;

/**
 * Class EventReminderNotification
 *
 * Sends a reminder to a user about an upcoming event they have registered
 * for. Always sends a database notification; sends an email if the user
 * has opted in. The notification message includes the event title and
 * start time.
 */
class EventReminderNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(protected Event $event)
    {
    }

    public function via(mixed $notifiable): array
    {
        $channels = ['database'];
        if (method_exists($notifiable, 'receive_event_reminder_email') && $notifiable->receive_event_reminder_email) {
            if ($notifiable->email) {
                $channels[] = 'mail';
            }
        }
        return $channels;
    }

    public function toArray(mixed $notifiable): array
    {
        return [
            'event_id' => $this->event->id,
            'title'    => $this->event->title,
            'starts_at'=> $this->event->starts_at?->toDateTimeString(),
        ];
    }

    public function toMail(mixed $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Event Reminder: '.$this->event->title)
            ->greeting('Hello!')
            ->line('You are registered for the event: '.$this->event->title)
            ->line('Start Time: '.$this->event->starts_at?->format('F j, Y g:i A'))
            ->line('Location: '.$this->event->location)
            ->line('We look forward to seeing you!');
    }
}