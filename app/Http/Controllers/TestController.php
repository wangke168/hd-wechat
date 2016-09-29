<?php

namespace App\Http\Controllers;

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
            ->whereDate('endtime','>=','2016-09-28')
            ->orderBy('id','desc')
            ->get();
        foreach ($row as $OpenidInfo) {
            $this->dispatch(new UpdateOpenidQueue($OpenidInfo));
            }
    }

}
