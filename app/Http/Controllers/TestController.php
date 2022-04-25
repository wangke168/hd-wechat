<?php

namespace App\Http\Controllers;

use App\Jobs\ConfrimOrderQueue;
use App\Jobs\SendOrderQueue;
use App\Jobs\UpdateClickQueue;
use App\Jobs\UpdateEscQueue;
use App\Jobs\UpdateOpenidQueue;
use App\WeChat\Tour;
use EasyWeChat\Foundation\Application;
use Illuminate\Http\Request;
use DB;
use EasyWeChat\Message\News;
use EasyWeChat\Message\Text;
use EasyWeChat\Message\Image;
use App\Models\WechatImage;
use App\Models\WechatTxt;
use App\Models\WechatVoice;
use App\Http\Requests;
use App\Models\WechatArticle;
use App\WeChat\Response;
use App\WeChat\Zone;
use Carbon\Carbon;
use App\WeChat\Usage;
class TestController extends Controller
{
    public $app;
    public $usage;
    public $order;
    public $openid_1;   //正式
    public $openid_1_1; //正式加密
    public $openid_2;   //测试
    public $openid_2_2;  //测试加密
    public function __construct(Application $app)
    {
        $this->app=$app;
        $this->openid_1='o2e-YuBgnbLLgJGMQykhSg_V3VRI';
        $this->openid_1_1='04faIYgdOH15020shuCxbbuWLPmrjTdsVj92Hw5edgc1Uboe0tAg6OZWxi9uul5IKYq7Ccybm7[c]b';
        $this->openid_2='opUv9v977Njll_YHpZYMymxI_aPE';
        $this->openid_2_2='7e04yjiCLT2vHOnPmpZRGzfemN[c]iXOPS8uNYq2[a]KEoO5NinNsC8YNFjfYxZUVm8yOY7Y1SnV2tgQ';
    }


    public  function temp()
    {
        /*$response = new Response();
        $openid='owKxH66HrTEWOkIWmbORCnClalAg';
        $keyword="企微";
        $eventkey="1017";*/

//        return $this->request_news1($openid, $eventkey, '1', '', '');

    /*    $tag = $this->app->user_tag;

        $userTags = $tag->userTags($openid);
        return $userTags;*/

        $app = app('wechat');
        $zone = new Zone();
        $date = Carbon::now()->toDateString();
        $rows_show = DB::table('zone_show_info')
            ->where('is_push', '1')
            ->orderBy('id', 'desc')
            ->get();
//        return $rows_show;
        foreach ($rows_show as $row_show) {
            $row_show_time = DB::table('zone_show_time')
                ->whereDate('startdate', '<=', $date)
                ->whereDate('enddate', '>=', $date)
                ->where('show_id', $row_show->id)
                ->orderBy('is_top', 'desc')
                ->first();
//            var_dump($row_show_time);
            $show_time = explode(',', $row_show_time->show_time);
            $prevtime = date('Y-m-d');

            foreach ($show_time as $show_time_detail) {
                $temptime = (strtotime($show_time_detail) - strtotime("now")) / 60;
//                echo  $temptime."<br>";
                if ($temptime < 30 && $temptime > 0) {
//                    echo  $temptime."<br>";
                    $row1 = DB::table('wx_user_info')
                        ->where('eventkey', $row_show->eventkey)
                        ->where('scandate', date('Y-m-d'))
                        ->where('esc','0')
//                        ->where('scandate',date('Y-m-d'))
//                        ->whereRaw('UNIX_TIMESTAMP(endtime)>=' . strtotime($prevtime))
                        ->get();
                    return ($row1);
                    foreach ($row1 as $send_openid) {
                        $content = new Text();
                        echo $send_openid->wx_openid;
                        echo  "您好，" . $zone->get_zone_info($row_show->zone_id)->zone_name . "景区" . $row_show->show_name . "的演出时间是" . $show_time_detail . "。还没到剧场的话要抓紧了哦。\n如果您不知道剧场位置，<a href='" . $row_show->show_place_url . "'>点我</a>\n微信演出时间有时无法及时更新，以景区公示为准。";
                        $content->content = "您好，" . $zone->get_zone_info($row_show->zone_id)->zone_name . "景区" . $row_show->show_name . "的演出时间是" . $show_time_detail . "。还没到剧场的话要抓紧了哦。\n如果您不知道剧场位置，<a href='" . $row_show->show_place_url . "'>点我</a>\n微信演出时间有时无法及时更新，以景区公示为准。";
//                        var_dump($content);
                        $this->app->staff->message($content)->by('1001@u_hengdian')->to($send_openid->wx_openid)->send();
//                        $this->app->staff->message($content)->by('1001@u_hengdian')->to($openid)->send();
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
                                ->where('esc','0')
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
            /*    else{
                    echo "sdas";
                }*/
                $prevtime = $show_time_detail;
            }

        }

    }

    private function autosendshowinfo()
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
                        ->where('esc','0')
                        ->whereRaw('UNIX_TIMESTAMP(endtime)>=' . strtotime($prevtime))
                        ->get();
                    return $row1;
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
                                ->where('esc','0')
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




    public function  request_news1($openid, $eventkey, $type, $keyword, $menuid)
    {
//        $wxnumber = Crypt::encrypt($openid);      //由于龙帝惊临预约要解密，采用另外的函数
//        $wxnumber = $this->usage->authcode($openid, 'ENCODE', 0);
//        $uid = $this->usage->get_uid($openid);
        if (!$eventkey) {
            $eventkey = 'all';
        }
        switch ($type) {
            case 1:
                $row = WechatArticle::focusPublished($eventkey)
                    ->skip(0)->take(8)->get();
                break;
            case 2:
                $row = WechatArticle::where('classid', $menuid)
                    ->usagePublished($eventkey)
                    ->skip(0)->take(8)->get();
                break;
            case 3:
                $keyword = $this->check_keywowrd($keyword);
                $row = WechatArticle::whereRaw('FIND_IN_SET("' . $keyword . '", keyword)')
                    ->usagePublished($eventkey)
                    ->skip(0)->take(8)->get();
                break;
        }
        if ($row) {
            $content = array();
            foreach ($row as $result) {
                $url = $result->url;
                $id = $result->id;
                /*如果只直接跳转链接页面时，判断是否已经带参数*/
                if ($url != '') {
                    /*链接跳转的数据统计*/
//                    $url = "http://wechat.hengdianworld.com/jump/{$id}/{$openid}";
                    $url = "https://" . $_SERVER['HTTP_HOST'] . "/jump/{$id}/{$openid}";

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
                    $url = "https://" . $_SERVER['HTTP_HOST'] . "/article/detail?id=" . $id . "&wxnumber=" . $wxnumber;

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

                $pic_url = "https://wx-control.hdyuanmingxinyuan.com/" . $result->picurl;

                /*索引图检查结束*/
                $new = new News();
                $new->title = $result->title;
                $new->description = $result->description;
                $new->url = $url;
//                $new->image = "http://weix2.hengdianworld.com/" . $result->picurl;
                $new->image = $pic_url;
                $content[] = $new;
            }
            $wechat = app('wechat');
            $wechat->server->setMessageHandler(function ($message) {


            });
//            return $new;
//            $this->app->staff->message($content)->by('1001@u_hengdian')->to($openid)->send();
        }

    }




    //更新wx_user_info的信息
    public function update_openid_info()
    {
        $row = DB::table('wx_user_info')
            ->where('esc', '0')
//            ->whereDate('endtime','>=',date("Y-m-d", strtotime("-1 day")))
            ->whereDate('endtime','>=','2017-02-24')
            ->orderBy('id','desc')
            ->get();
        foreach ($row as $OpenidInfo) {
            $this->dispatch(new UpdateOpenidQueue($OpenidInfo));
            }
    }
    //更新wx_esc_info的信息
    public function update_esc_info()
    {
        $rowEsc=DB::table('wx_user_esc')
//            ->whereDate('esc_time','>=',date("Y-m-d", strtotime("-1 day")))
            ->whereDate('esc_time','>=','2016-12-16')
            ->get();
        foreach ($rowEsc as $EscInfo)
        {
            $this->dispatch(new UpdateEscQueue($EscInfo));
        }
    }
    //更新wx_click_hits的信息
    public function update_click_info()
    {
        $rowClick=DB::table('wx_click_hits')
//            ->whereDate('adddate','>=',date("Y-m-d", strtotime("-1 day")))
            ->whereDate('adddate','>=','2016-12-16')
            ->get();
        foreach ($rowClick as $clickinfo)
        {
            dispatch(new UpdateClickQueue($clickinfo));
        }
    }
    //发送订单wx_order_send,wx_order_detail
    public function order_send($sellid,$openid=null)
    {
        $this->dispatch(new SendOrderQueue($sellid,$openid));
    }
    //确认订单wx_order_confrim
    public function order_confrim($sellid,$openid=null)
    {
        $this->dispatch(new ConfrimOrderQueue($sellid,$openid));
    }


    public function test()
    {
    return Requests::getRequestUri();
        }

}
