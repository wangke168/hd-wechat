<?php

namespace App\Http\Controllers;

use App\Jobs\ConfrimOrderQueue;
use App\Jobs\SendOrderQueue;
use App\WeChat\Usage;
use EasyWeChat\Foundation\Application;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\WeChat\Order;
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

    public function send($sellid,$openid=null)
    {
        if ($this->check_order($sellid)) {
            $this->dispatch(new SendOrderQueue($sellid,$openid));
        }
    }
    
    public function confrim($sellid,$openid=null)
    {
        $this->dispatch(new ConfrimOrderQueue($sellid,$openid));
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
