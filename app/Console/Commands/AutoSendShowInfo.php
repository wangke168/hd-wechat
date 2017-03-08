<?php

namespace App\Console\Commands;

use App\WeChat\Tour;
use App\WeChat\Usage;
use App\WeChat\Zone;
use Carbon\Carbon;
use EasyWeChat\Message\Text;
use Illuminate\Console\Command;
use DB;

class AutoSendShowInfo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'AutoSendShowInfo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'AutoSendShowInfo';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $app = app('wechat');
        $zone = new Zone();
        $date = Carbon::now()->toDateString();
        $rows_show = DB::table('zone_show_info')
            ->where('is_push', '1')
            ->orderBy('id', 'desc')
            ->get();
        foreach ($rows_show as $row_show) {
            $row_show_time = DB::table('zone_show_time')
                ->whereDate('startdate', '<=', $date)
                ->whereDate('enddate', '>=', $date)
                ->where('show_id', $row_show->id)
                ->orderBy('is_top', 'desc')
                ->first();

            $show_time = explode(',', $row_show_time->show_time);
            $prevtime = date('Y-m-d');
            foreach ($show_time as $show_time_detail) {
                $temptime = (strtotime($show_time_detail) - strtotime("now")) / 60;

                if ($temptime < 30 && $temptime > 0) {

                    $row1 = DB::table('wx_user_info')
                        ->where('eventkey', $row_show->eventkey)
                        ->where('scandate', date('Y-m-d'))
                        ->whereRaw('UNIX_TIMESTAMP(endtime)>=' . strtotime($prevtime))
                        ->get();

                    foreach ($row1 as $send_openid) {
                        $content = new Text();
                        $content->content = "您好，" . $zone->get_zone_info($row_show->zone_id)->zone_name . "景区" . $row_show->show_name . "的演出时间是" . $show_time_detail . "。还没到剧场的话要抓紧了哦。\n如果您不知道剧场位置，<a href='" . $row_show->show_place_url . "'>点我</a>\n微信演出时间有时无法及时更新，以景区公示为准。";
                        $app->staff->message($content)->by('1001@u_hengdian')->to($send_openid->wx_openid)->send();

                    }
                    /*检查景区eventkey下有没有其他二维码，例：龙帝惊临项目在秦王宫里，因此龙帝惊临和秦王宫的二维码是从属关系，扫龙帝惊临的二维码也能收到秦王宫的节目提醒*/
//                    $qrscene_id=$this->get_eventkey_info($result['eventkey']);
                    $Usage = new Usage();
                    $qrscene_id = $Usage->get_eventkey_son_info($row_show->eventkey);
                    if ($qrscene_id) {
                        foreach ($qrscene_id as $key => $eventkey) {

                            $row2 = DB::table('wx_user_info')
                                ->where('eventkey', $eventkey)
                                ->where('scandate', date('Y-m-d'))
                                ->whereRaw('UNIX_TIMESTAMP(endtime)>=' . strtotime($prevtime))
                                ->get();

                            foreach ($row2 as $send_openid) {
                                $content = new Text();
                                $content->content = "您好，" . $zone->get_zone_info($row_show->zone_id)->zone_name . "景区" . $row_show->show_name . "的演出时间是" . $show_time_detail . "。还没到剧场的话要抓紧了哦。\n如果您不知道剧场位置，<a href='" . $row_show->show_place_url . "'>点我</a>\n微信演出时间有时无法及时更新，以景区公示为准。";
                                $app->staff->message($content)->by('1001@u_hengdian')->to($send_openid->wx_openid)->send();
                            }
                        }
                    }
                }
                $prevtime = $show_time_detail;
            }

        }
    }
}
