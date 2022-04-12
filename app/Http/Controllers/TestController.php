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
use App\Models\WechatImage;
use App\Models\WechatTxt;
use App\Models\WechatVoice;
use App\Http\Requests;
use App\Models\WechatArticle;
use App\WeChat\Response;
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
        $response = new Response();
        $openid='owKxH66HrTEWOkIWmbORCnClalAg';
        $keyword="企微";
        $eventkey="1017";
        return WechatArticle::focusPublished($eventkey)->first();
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
