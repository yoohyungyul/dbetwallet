<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        // Commands\Inspire::class,

        \App\Console\Commands\SendLoop::class,
        \App\Console\Commands\WalletConfirm::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('send:loop')->everyMinute();
        $schedule->command('wallet:confirm')->everyMinute();
        // $schedule->command('inspire')
        //          ->hourly();
    }
}
