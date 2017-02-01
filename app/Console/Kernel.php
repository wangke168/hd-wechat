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
//        Commands\Update_Openid_Info::class,
        Commands\AutoSendShowInfo::class,
        Commands\CancelTag::class,
        Commands\AutoRemindLdjl::class,
        Commands\UpdateClickInfo::class,
        Commands\UpdateOpenidInfo::class,
        Commands\UpdateEscInfo::class,

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
        /*更新wx_user_info里的信息*/
/*        $schedule->command('update_openid_info')
            ->dailyAt('2:00');*/

        /*演艺秀自动推送*/
    //    $schedule->command('AutoSendShowInfo')
     //       ->cron('*/20 8-18 * * *');

        /*取消电影博物馆的tag*/
        $schedule->command('CancelTag')
            ->daily();

        /*龙帝惊临预约提醒*/
    //    $schedule->command('AutoRemindLdjl')
    //        ->cron('*/20 9-16 * * *');

        /*更新wx_user_info里的信息*/
        $schedule->command('UpdateOpenidInfo')
            ->dailyAt('1:00');

        /*更新wx_click_hits中的eventkey*/
        $schedule->command('UpdateClickInfo')
            ->dailyAt('1:30');

        /*更新wx_user_esc*/
        $schedule->command('UpdateEscInfo')
            ->dailyAt('2:00');


    }
}
