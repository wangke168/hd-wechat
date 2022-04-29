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
use App\WeChat\OpenID;
use EasyWeChat\User\User;

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
        $this->app = $app;
        $this->openid_1 = 'o2e-YuBgnbLLgJGMQykhSg_V3VRI';
        $this->openid_1_1 = '04faIYgdOH15020shuCxbbuWLPmrjTdsVj92Hw5edgc1Uboe0tAg6OZWxi9uul5IKYq7Ccybm7[c]b';
        $this->openid_2 = 'opUv9v977Njll_YHpZYMymxI_aPE';
        $this->openid_2_2 = '7e04yjiCLT2vHOnPmpZRGzfemN[c]iXOPS8uNYq2[a]KEoO5NinNsC8YNFjfYxZUVm8yOY7Y1SnV2tgQ';
    }


    public function temp3(){

//        date('r', Unix timestamp)
        $openid="o2e-YuPBZKIblGOOVoBY0SyINMQM";
        $usage = new Usage();
        $eventkey=$usage->get_openid_info($openid)->eventkey;
        return $eventkey;

    }


    public function temp(Request $request)
    {
        /*$userService = $this->app->user;
        $next_OpenId = null;
        for ($i = 1; $i <= 2; $i++) {
            $users = $userService->lists($nextOpenId = $next_OpenId);
            $userall = $users["data"]["openid"];
            foreach ($userall as $user) {
                echo $user . "</br>";
                $next_OpenId = $user;
            }
            if ($nextOpenId == $next_OpenId) {
                break;
            }
        }*/

        $raw = DB::table("wx_user_info_copy2")
            ->orderBy('id', 'desc')
            ->first();
        if (!$raw) {
            $next_OpenId = null;
        } else {
            $next_OpenId = $raw->wx_openid;
        }
        $userService = $this->app->user;
        for ($i = 1; $i <= 10; $i++) {
            $users = $userService->lists($nextOpenId = $next_OpenId);
            $userall = $users["data"]["openid"];
            foreach ($userall as $user) {
                // echo $user . "</br>";
                $next_OpenId = $user;

                DB::table("wx_user_info_copy2")
                    ->insert(['wx_openid' => $user]);
            }
        }
        echo "已完成";

    }

    public function temp2()
    {
        $row = DB::table('wx_user_info_copy')
//            ->where('esc', '0')
//            ->whereDate('endtime', '>=', date("Y-m-d", strtotime("-1 day")))
            //         ->whereDate('endtime','>=','2017-02-24')
            ->limit(100)
            ->orderBy('id', 'desc')
            ->get();
        foreach ($row as $OpenidInfo) {
  /*      $app = app('wechat');
        $token = $app->access_token->getToken();


            $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=" . $token . "&openid=" . $OpenidInfo->wx_openid;
            $json = $this->http_request_json($url);//这个地方不能用file_get_contents
            $data = json_decode($json, true);

            $subscribe_time = $data['subscribe_time'];
            $unionid = $data['unionid'];
            $subscribe_scene = $data["subscribe_scene"];
            $qr_scene = $data["qr_scene"];
            $qr_scene_str = $data["qr_scene_str"];

            DB::table('wx_user_info_copy')
                ->where('id', $OpenidInfo->id)
                ->update(['subscribe_time' => $subscribe_time,'unionid' => $unionid, 'subscribe_scene' => $subscribe_scene, 'qr_scene' => $qr_scene,'qr_scene_str' => $qr_scene_str]);
*/



            dispatch(new UpdateOpenidQueue($OpenidInfo));
//            $this->dispatch(new UpdateQueue($OpenidInfo));
        }
    }

//因为url是https 所有请求不能用file_get_contents,用curl请求json 数据
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
    public function request_news1($openid, $eventkey, $type, $keyword, $menuid)
    {
        $wxnumber = Crypt::encrypt($openid);      //由于龙帝惊临预约要解密，采用另外的函数
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
            ->whereDate('endtime', '>=', '2017-02-24')
            ->orderBy('id', 'desc')
            ->get();
        foreach ($row as $OpenidInfo) {
            $this->dispatch(new UpdateOpenidQueue($OpenidInfo));
        }
    }

    //更新wx_esc_info的信息
    public function update_esc_info()
    {
        $rowEsc = DB::table('wx_user_esc')
//            ->whereDate('esc_time','>=',date("Y-m-d", strtotime("-1 day")))
            ->whereDate('esc_time', '>=', '2016-12-16')
            ->get();
        foreach ($rowEsc as $EscInfo) {
            $this->dispatch(new UpdateEscQueue($EscInfo));
        }
    }

    //更新wx_click_hits的信息
    public function update_click_info()
    {
        $rowClick = DB::table('wx_click_hits')
//            ->whereDate('adddate','>=',date("Y-m-d", strtotime("-1 day")))
            ->whereDate('adddate', '>=', '2016-12-16')
            ->get();
        foreach ($rowClick as $clickinfo) {
            dispatch(new UpdateClickQueue($clickinfo));
        }
    }

    //发送订单wx_order_send,wx_order_detail
    public function order_send($sellid, $openid = null)
    {
        $this->dispatch(new SendOrderQueue($sellid, $openid));
    }

    //确认订单wx_order_confrim
    public function order_confrim($sellid, $openid = null)
    {
        $this->dispatch(new ConfrimOrderQueue($sellid, $openid));
    }


    public function test()
    {
        return Requests::getRequestUri();
    }

}
