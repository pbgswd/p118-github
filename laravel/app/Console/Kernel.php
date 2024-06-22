<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('employment:update-status')->daily();
        $schedule->command('message:now')->everyMinute();
        $schedule->command('message:daily')->dailyAt('12:00');
        $schedule->command('message:weekly')->weeklyOn('friday', '17:00');

        // $schedule->command( Log::info('test'.time() . " " . date('l jS \of F Y h:i:s A')))->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
