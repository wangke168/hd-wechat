<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use Doctrine\Common\Cache\Cache;
use Doctrine\Common\Cache\MemcachedCache;
use App\WeChat\Tour;
use App\WeChat\Usage;
use EasyWeChat\Message\Text;
use DB;
use App\Models\WechatArticle;
use Illuminate\Http\Request;
use App\Http\Requests;
use Carbon\Carbon;

class TestController extends Controller
{
    protected $cache;
    public function __construct(Cache $cache = null)
    {
        $this->cache = $cache;
    }
    public function test()
    {

        $app=app('wechat');
        $zone=new Tour();
        $row=DB::table('tour_project_info')
            ->orderBy('id','desc')
            ->get();
        foreach ($row as $result) {
            $aaa = explode(',', $result->show_time);
            $prevtime = date('Y-m-d');
            foreach ($aaa as $bbb) {
                $temptime = (strtotime($bbb) - strtotime("now")) / 60;
                if ($temptime < 30 && $temptime > 0) {

                    $row1 = DB::table('wx_user_info')
                        ->where('eventkey', $result->eventkey)
                        ->where('scandate', date('Y-m-d'))
                        ->whereRaw('UNIX_TIMESTAMP(endtime)>=' . strtotime($prevtime))
                        ->get();

                    foreach ($row1 as $send_openid) {
                        $content = new Text();
                        $content->content = "您好，" . $zone->get_zone_name($result->zone_id,'1') . "景区" . $result->show_name . "的演出时间是" . $bbb . "。还没到剧场的话要抓紧了哦。\n如果您不知道剧场位置，<a href='" . $result->location_url . "'>点我</a>\n微信演出时间有时无法及时更新，以景区公示为准。";
                        $app->staff->message($content)->by('1001@u_hengdian')->to('o2e-YuBgnbLLgJGMQykhSg_V3VRI')->send();
//                        return $content;
                    }


                    /*检查景区eventkey下有没有其他二维码，例：龙帝惊临项目在秦王宫里，因此龙帝惊临和秦王宫的二维码是从属关系，扫龙帝惊临的二维码也能收到秦王宫的节目提醒*/
//                    $qrscene_id=$this->get_eventkey_info($result['eventkey']);
                    $Usage = new Usage();
                    $qrscene_id = $Usage->get_eventkey_son_info($result->eventkey);
                    if ($qrscene_id) {
                        foreach ($qrscene_id as $key => $eventkey) {

                            $row2 = DB::table('wx_user_info')
                                ->where('eventkey', $eventkey)
                                ->where('scandate', date('Y-m-d'))
                                ->whereRaw('UNIX_TIMESTAMP(endtime)>=' . strtotime($prevtime))
                                ->get();

                            foreach ($row2 as $send_openid) {
                                $content = new Text();
                                $content->content = "您好，" . $zone->get_zone_name($result->zone_id,'1') . "景区" . $result->show_name . "的演出时间是" . $bbb . "。还没到剧场的话要抓紧了哦。\n如果您不知道剧场位置，<a href='" . $result->location_url . "'>点我</a>\n微信演出时间有时无法及时更新，以景区公示为准。";
                                $app->staff->message($content)->by('1001@u_hengdian')->to('o2e-YuBgnbLLgJGMQykhSg_V3VRI')->send();
//                                return $content;
                            }
                        }
                    }

                }
                $prevtime = $bbb;
            }
        }
    }

    public function qrcreate()
    {
        for ($k='1366'; $k <'1368' ; $k++) { 
            $qrscene_name='永康酒店'&($k-1365);
             $row=DB::table('wx_qrscene_info')
        ->insert(['classid'=>'1','qrscene_id'=>$i,'qrscene_name'=>$qrscene_name]);
        return $row;
        }
       
    }

     public function detail_test(Request $request)
     {



     }

    public function cache()
    {
        $this->getCache()->save('testcach', 'wechat', 6500 - 1500);

    }
    private function getCache()
    {
        return $this->cache ?: $this->cache=new MemcachedCache();
        // return $this->cache ?: $this->cache = new FilesystemCache(sys_get_temp_dir());
    }
}