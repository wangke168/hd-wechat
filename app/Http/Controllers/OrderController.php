<?php

namespace App\Http\Controllers;

use App\Jobs\ConfrimOrderQueue;
use App\Jobs\SendOrderQueue;
use App\WeChat\Usage;
use EasyWeChat\Foundation\Application;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests;

class OrderController extends Controller
{
    //
    public $app;
    public $notice;
    public $usage;

    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->notice = $app->notice;
        $this->usage = new Usage();
    }

    public function send($openid, $sellid)
    {
        if ($this->check_order($sellid)) {
            $this->dispatch(new SendOrderQueue($openid,$sellid));
        }
    }
    
    public function confrim($openid, $sellid)
    {
        $this->dispatch(new ConfrimOrderQueue($openid,$sellid));
        
    }


    private function check_order($sellid)
    {
        $row = DB::table('wx_order_send')
            ->where('sellid', $sellid)
            ->count();

        if ($row == 0) {
            $flag = true;
        } else {
            $flag = false;
        }
        return $flag;
    }
}
