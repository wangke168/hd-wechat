<?php

namespace App\Http\Controllers;

use App\Jobs\SendOrderQueue;
use App\Jobs\UpdateClickQueue;
use App\Jobs\UpdateOpenidQueue;
use EasyWeChat\Foundation\Application;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests;

class TestController extends Controller
{
    public $app;
    public $usage;
    public $order;

    public function __construct(Application $app)
    {
        $this->app=$app;
    }


    //更新wx_user_info的信息
    public function update_openid_info()
    {
        $row = DB::table('wx_user_info')
            ->where('esc', '0')
            ->whereDate('endtime','>=','2016-08-28')
            ->orderBy('id','desc')
            ->get();
        foreach ($row as $OpenidInfo) {
            $this->dispatch(new UpdateOpenidQueue($OpenidInfo));
            }
    }
    //更新wx_click_hits的信息
    public function update_click_info()
    {
        $rowClick=DB::table('wx_click_hits')
//            ->whereDate('adddate','>=',date("Y-m-d", strtotime("-1 day")))
            ->whereDate('adddate','>=','2016-09-28')
            ->get();
        foreach ($rowClick as $clickinfo)
        {
            dispatch(new UpdateClickQueue($clickinfo));
        }
    }
    //发送订单
    public function send_order($sellid,$openid=null)
    {
        $this->dispatch(new SendOrderQueue($sellid,$openid));
//        dispatch(new SendOrderQueue($sellid,$openid));
        //openid=7e04yjiCLT2vHOnPmpZRGzfemN[c]iXOPS8uNYq2[a]KEoO5NinNsC8YNFjfYxZUVm8yOY7Y1SnV2tgQ;
    }
}
