<?php

namespace App\Console\Commands;

use App\WeChat\Usage;
use EasyWeChat\Message\Text;
use Illuminate\Console\Command;
use DB;

class auto_send_show_info extends Command
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

       /* $db = new DB();
        $response = new responseMsg();*/
//        $row = $db->query("Select * from wx_location_list");
        $app=app('wechat');
        $row=DB::table('wx_location_list')
            ->orderBy('id','desc')
            ->get();
        foreach ($row as $result) {
            $aaa = explode(',', $result->show_time);
            $prevtime = "";
            foreach ($aaa as $bbb) {
//        if (strtotime($bbb)-(strtotime("now"))/60)
                $temptime = (strtotime($bbb) - strtotime("now")) / 60;
                if ($temptime < 30 && $temptime>0) {
/*                    $row1 = $db->query("SELECT * from wx_user_info where eventkey=:eventkey  and scandate = :days and UNIX_TIMESTAMP(endtime)>=:endtime order by id desc",
                        array("eventkey" => $result['eventkey'], "days" => date('Y-m-d'),"endtime"=>strtotime($prevtime)));*/

                    $row1=DB::table('wx_user_info')
                        ->where('eventkey',$result->eventkey)
                        ->whereDate('scandate',date('Y-m-d'))
                        ->whereRaw('UNIX_TIMESTAMP(endtime)>='.strtotime($prevtime))
                        ->get();

                    foreach ($row1 as $send_openid) {
/*                        $response->responseV_Text($ccc["wx_openID"], "您好，" .$result["zone_id"]."景区". $result["show_name"]."的演出时间是".$bbb."。还没到剧场的话要抓紧了哦。\n如果您不知道剧场位置，<a href='".$result["location_url"]."'>点我</a>\n微信演出时间有时无法及时更新，以景区公示为准。");
                        $response->responseV_News($ccc['wx_openID'], $result["show_name"], "2");*/
                        $content=new Text();
                        $content->content="您好，" .$result->zone_id."景区". $result->show_name."的演出时间是".$bbb."。还没到剧场的话要抓紧了哦。\n如果您不知道剧场位置，<a href='".$result->location_url."'>点我</a>\n微信演出时间有时无法及时更新，以景区公示为准。";
                        $app->staff->message($content)->by('1001@u_hengdian')->to($send_openid->wx_openid)->send();
                    }


                    /*检查景区eventkey下有没有其他二维码，例：龙帝惊临项目在秦王宫里，因此龙帝惊临和秦王宫的二维码是从属关系，扫龙帝惊临的二维码也能收到秦王宫的节目提醒*/
//                    $qrscene_id=$this->get_eventkey_info($result['eventkey']);
                    $Usage=new Usage();
                    $qrscene_id=$Usage->get_eventkey_son_info($result->eventkey);
                    if($qrscene_id)
                    {
                        foreach($qrscene_id as $key=>$eventkey)
                        {
                /*            $row2 = $db->query("SELECT * from wx_user_info where eventkey=:eventkey  and scandate = :days and UNIX_TIMESTAMP(endtime)>=:endtime order by id desc",
                                array("eventkey" => $eventkey, "days" => date('Y-m-d'),"endtime"=>strtotime($prevtime)));*/

                            $row2=DB::table('wx_user_info')
                                ->where('eventkey',$result->eventkey)
                                ->whereDate('scandate',date('Y-m-d'))
                                ->whereRaw('UNIX_TIMESTAMP(endtime)>='.strtotime($prevtime))
                                ->get();

                            foreach ($row2 as $send_openid) {
                              /*  $response->responseV_Text($ddd["wx_openID"], "您好，" .$result["zone_id"]."景区". $result["show_name"]."的演出时间是".$bbb."。还没到剧场的话要抓紧了哦。\n如果您不知道剧场位置，<a href='".$result["location_url"]."'>点我</a>\n微信演出时间有时无法及时更新，以景区公示为准。");
                                $response->responseV_News($ddd['wx_openID'], $result["show_name"], "2");*/
                                $content=new Text();
                                $content->content="您好，" .$result->zone_id."景区". $result->show_name."的演出时间是".$bbb."。还没到剧场的话要抓紧了哦。\n如果您不知道剧场位置，<a href='".$result->location_url."'>点我</a>\n微信演出时间有时无法及时更新，以景区公示为准。";
                                $app->staff->message($content)->by('1001@u_hengdian')->to($send_openid->wx_openid)->send();
                            }
                        }
                    }

                }
                $prevtime=$bbb;
            }
        }


    }
}
