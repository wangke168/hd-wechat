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
use App\Models\WechatMiniPage;
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
use EasyWeChat\Message\Raw;
use App\Jobs\SendSecondQueue;
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
        $this->openid_1 = 'o2e-YuNJXi3oNOkH_dh23FZtGFnk';
        $this->openid_1_1 = '04faIYgdOH15020shuCxbbuWLPmrjTdsVj92Hw5edgc1Uboe0tAg6OZWxi9uul5IKYq7Ccybm7[c]b';
        $this->openid_2 = 'opUv9v977Njll_YHpZYMymxI_aPE';
        $this->openid_2_2 = '7e04yjiCLT2vHOnPmpZRGzfemN[c]iXOPS8uNYq2[a]KEoO5NinNsC8YNFjfYxZUVm8yOY7Y1SnV2tgQ';
    }


    public function temp3()
    {

//        date('r', Unix timestamp)
         $openid="o2e-YuETJD7rL1j_SWRw145hilFI";
         /*$usage = new Usage();
         $eventkey=$usage->get_openid_info($openid)->eventkey;
         return $eventkey;*/

        $openid = "o2e-YuBHJhzVkrzP7t2qPEk_kr3c";
        $userService = $this->app->user;
        return  $userService->get($openid);
        $row1 = DB::table('wx_user_info')
            ->where('eventkey', '2098')
            ->where('scandate', date('Y-m-d'))
            ->where('esc','0')
//                        ->whereRaw('UNIX_TIMESTAMP(endtime)>=' . strtotime($prevtime))
            ->get();
        foreach ($row1 as $send_openid) {

//            foreach ($row as $result) {
            $minipage = array('touser' => $send_openid->wx_openid, 'msgtype' => 'miniprogrampage',
                'miniprogrampage' => array(
                    'title' => "测试",
                    'appid' => "wxd2e8a996a486b48b",
                    'pagepath' => "/pages/productDetail/productDetail?productId=23688586&dt=52882390",
                    'thumb_media_id' => "y1_Ypabgd3rcrb6YdsaJjrAaAaXBXQpcK5DHIJ8mQHja0-bHY3yj1r3BazT3XN3_",));
            $content=json_encode($minipage,JSON_UNESCAPED_UNICODE);
            $message=new Raw($content);
            $this->app->staff->message($message)->by('1001@u_hengdian')->to($send_openid->wx_openid)->send();

        }
       /* $arr2 = array('touser' => $openid, 'msgtype' => 'miniprogrampage',
            'miniprogrampage' => array(
                'title' => '开始预约',
                'appid' => 'wxb07d9741a63f038f',
                'pagepath' => '/packageA/pages/gym-detail/gym-detail?id=13990',
                'thumb_media_id' => 'y1_Ypabgd3rcrb6YdsaJjlGFUD20hq_ye7S9pgdpiJBtdWR5RsTJhCIR-ponseyY',));

        $content=json_encode($arr2,JSON_UNESCAPED_UNICODE);
        $message=new Raw($content);
        $this->app->staff->message($message)->by('1001@u_hengdian')->to($openid)->send();*/

        /*$row_minipage = WechatMiniPage:: focusPublished($eventkey)->first();
        return $row_minipage;

        $row = WechatMiniPage::focusPublished($eventkey)
            ->orderBy('id', 'desc')
            ->get();
        foreach ($row as $result) {
            $minipage = array('touser' => $openid, 'msgtype' => 'miniprogrampage',
                'miniprogrampage' => array(
                    'title' => $result->title,
                    'appid' => $result->appid,
                    'pagepath' => $result->pagepath,
                    'thumb_media_id' => $result->media_id,));
            $content=json_encode($minipage,JSON_UNESCAPED_UNICODE);
            $message=new Raw($content);
            $this->app->staff->message($message)->by('1001@u_hengdian')->to($openid)->send();
        }*/
    }


    public function temp(Request $request)
    {
        $openid='o2e-YuNJXi3oNOkH_dh23FZtGFnk';
        $results = DB::table('wx_order_send')
            ->where('Arrivate_Date', date('Y-m-d'))
            ->where('ygjd','not like','%套餐%')
            ->where('ygjd','not like','%季卡%')
            ->where('ygjd','not like','%年卡%')
            ->get();

        foreach ($results as  $result)
        {
            $this->dispatch(new SendSecondQueue($result->wx_openid));
//            $this->app->staff->message($content)->by('1001@u_hengdian')->to($result->wx_openid)->send();
        }
        return $results;
        $keyword='测试';
        $eventkey='1007';
        
    }



    public function temp2()
    {


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
