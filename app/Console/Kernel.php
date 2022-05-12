<?php

namespace App\Console;

use App\Jobs\UpdateSteamAccounts;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();

        $schedule->command('ban:delete-expired')->everyMinute();
        $schedule->command('mission:close')->everyMinute();
        $schedule->command('updater:clean')->timezone('Asia/Seoul')->dailyAt('06:00');
        $schedule->command('user:pause-auto')->timezone('Asia/Seoul')->dailyAt('05:00');
        $schedule->command('account:update steam')->timezone('Asia/Seoul')->monthlyOn(1, '04:00');
        $schedule->command('azure:update instances')->hourly();
        $schedule->command('azure:update budges')->cron('0 */12 * * *');
        $schedule->command('azure:update usage')->everyFourHours();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
