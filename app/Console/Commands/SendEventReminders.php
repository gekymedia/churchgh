<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use App\Models\Event;
use App\Models\EventRegistration;
use App\Notifications\EventReminderNotification;

/**
 * Class SendEventReminders
 *
 * Artisan command to send reminders for upcoming events. The command finds
 * events starting within the next 24 hours (including today) and sends
 * notifications to users who have registered for those events. Users can
 * opt out of email reminders via their preferences; in‑app notifications
 * are always sent.
 */
class SendEventReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'events:remind';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminders for upcoming events to registered members';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $now = Carbon::now();
        $tomorrow = $now->copy()->addDay();
        // Fetch events starting between now and 24 hours from now
        $events = Event::where('starts_at', '>=', $now)
            ->where('starts_at', '<=', $tomorrow)
            ->get();
        if ($events->isEmpty()) {
            $this->info('No events to remind within the next 24 hours.');
            return self::SUCCESS;
        }
        foreach ($events as $event) {
            foreach ($event->registrations as $registration) {
                $user = $registration->user;
                if (!$user) {
                    continue;
                }
                $user->notify(new EventReminderNotification($event));
            }
        }
        $this->info('Event reminders dispatched.');
        return self::SUCCESS;
    }
}