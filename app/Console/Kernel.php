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
//        \App\Console\Commands\Inspire::class,
        \App\Console\Commands\Update_Openid_Info::class,
        \App\Console\Commands\AutoSendShowInfo::class,

    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
/*        $schedule->command('inspire')
            ->everyMinute();*/
        //更新wx_user_info里的信息
        $schedule->command('update_openid_info')
            ->dailyAt('2:00');
        $schedule->command('AutoSendShowInfo')
            ->cron('* 8-18 * * *');
    }
}
