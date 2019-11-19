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
        //
        Commands\test::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        date_default_timezone_set('Asia/Shanghai');
        // $schedule->command('inspire')
        //          ->hourly();
//        $schedule->command('test')->everyMinute();
        /**
         * Everyday update consume total amount
         */
//        $schedule->command('consume')->everyMinute();
//        $schedule->command('consume')->everyMinute();
        $schedule->command('consume')->dailyAt('23:23');
//        $schedule->call(function () {
//            file_put_contents('/web/blog/storage/logs/'.date('Y-m-d').'/run.log', date('Y-m-d H:i:s')."\r\n", FILE_APPEND);
//        })->cron('* * * * * *');
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
