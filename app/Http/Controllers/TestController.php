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
        $id="1479";
        $jump_url=env('JUMP_URL','');
        $get_openid_url=$jump_url."?id=".$id;
        $openid=new OpenID();
        $wxnumber=$openid->GetOpenid($get_openid_url);
        return $wxnumber;

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
