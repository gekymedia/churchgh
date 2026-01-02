<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

/**
 * Class Kernel
 *
 * This console kernel registers command classes and defines the scheduler
 * for periodic tasks such as sending daily quotes and event reminders.
 */
class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Send daily quotes every day at 06:00
        $schedule->command('quotes:send')->dailyAt('06:00');

        // Send event reminders daily at 07:00
        $schedule->command('events:remind')->dailyAt('07:00');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');
        // You may require routes/console.php if present in the base project.
        $commandFile = base_path('routes/console.php');
        if (is_file($commandFile)) {
            require $commandFile;
        }
    }
}