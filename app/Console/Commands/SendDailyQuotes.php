<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use App\Models\Quote;
use App\Models\User;
use App\Notifications\DailyQuoteNotification;

/**
 * Class SendDailyQuotes
 *
 * Artisan command to dispatch the day's quotes to all users. The command
 * looks up any quotes scheduled for the current date and sends an
 * in‑app notification and an email (if the user has opted in). Use the
 * `dailyAt` scheduler in the console kernel to run this command.
 */
class SendDailyQuotes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'quotes:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send daily devotional quotes to members';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $today = Carbon::today();
        $quotes = Quote::where('delivery_date', $today->toDateString())->get();
        if ($quotes->isEmpty()) {
            $this->info('No quotes scheduled for today.');
            return self::SUCCESS;
        }
        $users = User::all();
        foreach ($users as $user) {
            foreach ($quotes as $quote) {
                $user->notify(new DailyQuoteNotification($quote));
            }
        }
        // Optionally mark quotes as sent
        foreach ($quotes as $quote) {
            $quote->sent_at = Carbon::now();
            $quote->save();
        }
        $this->info('Daily quotes sent to users.');
        return self::SUCCESS;
    }
}