<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use App\WeChat\Zone;
use Cache;
use App\WeChat\Tour;
use App\WeChat\Usage;
use EasyWeChat\Foundation\Application;
use EasyWeChat\Message\Text;
use DB;
use App\Models\WechatArticle;
use Illuminate\Http\Request;
use App\Http\Requests;
use Carbon\Carbon;
class TestController extends Controller
{
    public $app;
    public $js;
    public $usage;

    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->usage=new Usage();
        $this->js = $this->app->js;

    }


    public function temp()
    {

        $rows=DB::table('wx_order_detail')
            ->whereBetween('id',[440,804])
            ->get();

        $usage = new Usage();
        $eventkey = '';

        foreach ($rows as $result) {
            if ($usage->get_openid_info($result->wx_openid)) {
                $eventkey = $usage->get_openid_info($result->wx_openid)->eventkey;
            }
            $userId = $result->wx_openid;
            $url = 'https://wechat.hdyuanmingxinyuan.com/article/detail?id=1482';
            $color = '#FF0000';

            $ticket_id = "";
            $hotel = "";
            $ticket = "";
            $url = env('ORDER_URL', '');
            $json = file_get_contents($url . "searchorder_json.aspx?sellid=" . $result->sellid);
            $data = json_decode($json, true);

            $ticketcount = count($data['ticketorder']);
            $inclusivecount = count($data['inclusiveorder']);
            $hotelcount = count($data['hotelorder']);

            $i = 0;
            if ($ticketcount <> 0) {
                $ticket_id = 1;

                $name = $data['ticketorder'][0]['name'];
                $sellid = $data['ticketorder'][0]['sellid'];
                $date = $data['ticketorder'][0]['date2'];
                $ticket = $data['ticketorder'][0]['ticket'];
                $numbers = $data['ticketorder'][0]['numbers'];
                $adddate = $data['ticketorder'][0]['date1'];
                $flag = $data['ticketorder'][0]['flag'];
            }

            DB::table('wx_order_detail')
                ->where('id', $result->id)
                ->update(['sellid' => $sellid, 'k_name' => $name,
                    'arrivedate' => $date, 'ticket_id' => $ticket_id, 'ticket' => $ticket,
                     'eventkey' => $eventkey, 'numbers' => $numbers, 'adddate' => $adddate]);
        }

    }
    private function get_url($id)
    {
        $row = DB::table('wx_article')
            ->where('id', $id)
            ->first();
        return $row;
    }
    private function http_request_json($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    public function test()
    {
        $usage = new Usage();
        $openid='oZ9oauN--CwmBsrBbyAh3xhhcS20';
        $url = 'http://e-test.hdyuanmingxinyuan.com/yd_mp_activity.aspx?id=269';
        $wxnumber = $usage->authcode($openid, 'ENCODE', 0);
        echo $wxnumber;
        $uid = $usage->get_uid($openid);
        $eventkey = $usage->get_openid_info($openid)->eventkey;
        if ($this->CheckCardBan($eventkey))
        {
            $url = 'https://wechat.hdyuanmingxinyuan.com/article/detail?id=1495';
        }
        else
        {
            $url = $url . "&comefrom=1&wxnumber={$wxnumber}&uid={$uid}&wpay=1";
        }
        return $url;
    }
    private function CheckCardBan($eventkey)
    {
        $row=DB::table('wx_card_ban')
            ->where('id',1)
            ->first();
        if ($eventkey=='')
        {
            return true;
        }
        else {
            $tmparray = explode($eventkey, $row->eventkey);
            if (count($tmparray) > 1) {
                return true;
            } else {
                return false;
            }
        }

    }
    public function test1()
    {

        $app = app('wechat');
        $zone = new Tour();
        $row = DB::table('tour_project_info')
            ->orderBy('id', 'desc')
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
                        $content->content = "您好，" . $zone->get_zone_name($result->zone_id, '1') . "景区" . $result->show_name . "的演出时间是" . $bbb . "。还没到剧场的话要抓紧了哦。\n如果您不知道剧场位置，<a href='" . $result->location_url . "'>点我</a>\n微信演出时间有时无法及时更新，以景区公示为准。";
                        $app->staff->message($content)->by('1001@u_hengdian')->to($send_openid->wx_openid)->send();

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
                                $content->content = "您好，" . $zone->get_zone_name($result->zone_id, '1') . "景区" . $result->show_name . "的演出时间是" . $bbb . "。还没到剧场的话要抓紧了哦。\n如果您不知道剧场位置，<a href='" . $result->location_url . "'>点我</a>\n微信演出时间有时无法及时更新，以景区公示为准。";
                                $app->staff->message($content)->by('1001@u_hengdian')->to($send_openid->wx_openid)->send();
//                                return $content;
                            }
                        }
                    }

                }
                $prevtime = $bbb;
            }
        }
    }

    public function cache(Request $request)
    {

        if (Cache::has('temp')) {
//            return Cache::get('temp');
        } else {
            Cache::put('temp', 'cachekey', 60);
        }
//        return Cache::get('temp');


        $row = WechatArticle::where('classid', '15')
            ->usagePublished('all')
            ->skip(0)->take(8)->get();

        if ($row) {
            $content = array();
            foreach ($row as $result) {
                $url = $result->url;
                $id = $result->id;
                /*如果只直接跳转链接页面时，判断是否已经带参数*/
                if ($url != '') {
                    /*链接跳转的数据统计*/
//                    $url = "http://wechat.hengdianworld.com/jump/{$id}/{$openid}";
                    // $url = "http://".$_SERVER['HTTP_HOST']."/jump/{$id}/{$openid}";

                    /*          if (!strstr($url, 'project_id')) {
                                  if (strstr($url, '?') != '') {
                                      $url = $url . "&comefrom=1&wxnumber={$wxnumber}&uid={$uid}&wpay=1";
                                  } else {
                                      $url = $url . "?comefrom=1&wxnumber={$wxnumber}&uid={$uid}&wpay=1";
                                  }

                              } else {
                                  $url=$url . "&wxnumber={$openid}";
          //                        return redirect($url . "&wxnumber={$openid}");
                              }
          */
                } else {
//                    $url = "http://weix2.hengdianworld.com/article/articledetail.php?id=" . $id . "&wxnumber=" . $wxnumber;
                    //   $url = "http://".$_SERVER['HTTP_HOST']."/article/detail?id=" . $id . "&wxnumber=" . $wxnumber;

                }

                /*检查索引图所在服务器并生成链接*/
                /*     if(starts_with($result->picurl, 'uploads'))
                     {
                         $pic_url='http://weix2.hengdianworld.com/'.$result->picurl;
                     }
                     else
                     {
                         $pic_url="http://weix2.hengdianworld.com" . $result->picurl;
                     }*/

                $pic_url = 'http://weix2.hengdianworld.com/' . $result->picurl;

                /*索引图检查结束*/
                $new = new News();
                $new->title = $result->title;
                $new->description = $result->description;
                $new->url = $url;
//                $new->image = "http://weix2.hengdianworld.com/" . $result->picurl;
                $new->image = $pic_url;
                $content[] = $new;
            }

        }

    }
}