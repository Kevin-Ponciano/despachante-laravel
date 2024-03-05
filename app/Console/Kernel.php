<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        //$schedule->exec('echo "start Scheduling" > /log.txt')->everyMinute();
        // Backup
        //$schedule->command('backup:clean --disable-notifications')->daily()->at('04:00');
        //$schedule->command('backup:run --disable-notifications')->daily()->at('05:00');

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
