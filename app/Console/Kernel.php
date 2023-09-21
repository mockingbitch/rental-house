<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * @var array
     */
    protected $commands = [
        Commands\TeacherWeeklyCourseNotification::class,
        Commands\TeacherPreviousDayNotification::class,
        Commands\TeacherBeforeOneHourNotification::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('notificationteacher:weeklycourse')->weeklyOn(4, '16:30');
        $schedule->command('notificationteacher:previousdaycourse')->everyFiveMinutes();
        $schedule->command('notificationteacher:beforeonehourcourse')->everyFiveMinutes();
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
