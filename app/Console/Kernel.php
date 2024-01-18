<?php

namespace App\Console;

use App\Console\Commands\FetchTopTracksCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command(FetchTopTracksCommand::class)
            ->withoutOverlapping()
            ->weeklyOn(1, "03:00")
            ->timezone('America/New_York')
            ->sendOutputTo(storage_path('logs/fetch-toptracks.log'), true);
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
