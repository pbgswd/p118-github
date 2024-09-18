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
        //   $schedule->command('employment:update-status')->dailyAt('01:00');
        // Log::info('Kernel.php, for running the queue '.time() . " " . date('l jS \of F Y h:i:s A'));

        //  $schedule->command('message:now')->everyMinute();
        /**
        $schedule->command('message:daily')->dailyAt('12:00');
        $schedule->command('message:weekly')->weeklyOn(5, '17:00'); // 5 = friday
        //$schedule->command('message:weekly')->weekly()->fridays()->at('17:00'); // 5 = friday
        **/
        // $schedule->command( Log::info('test'.time() . " " . date('l jS \of F Y h:i:s A')))->everyMinute();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
