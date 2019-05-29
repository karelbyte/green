<?php

namespace App\Console;

use App\Console\Commands\NotifyDaily;
use App\Console\Commands\NotifyVisits;
use App\Console\Commands\TestComand;
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
        NotifyVisits::class,
        NotifyDaily::class
       // TestComand::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('notify:visits')->dailyAt('8:00');

        $schedule->command('notify:daily')->dailyAt('8:00');

      //  $schedule->command('prueba:test')->everyMinute();
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
