<?php

namespace App\Jobs;

use DB;
use App\Jobs\Job;
use App\WeChat\Order;
use App\WeChat\Usage;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ConfrimOrderQueue extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    public $sellid;
    public $openid;

    
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($openid, $sellid)
    {
     /*   $this->usage=new Usage();
        $this->order=new Order();*/
//        $this->openid = $this->usage->authcode($openid, 'DECODE', 0);
        $this->openid=$openid;
        $this->sellid = $sellid;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $usage=new Usage();
        $order=new Order();
        $openId = $usage->authcode($this->openid, 'DECODE', 0);
        $eventkey = $usage->get_openid_info($openId)->eventkey;     //获取客人所属市场
        $focusdate = $usage->get_openid_info($openId)->adddate;     //获取客人关注时间
        $name=$order->get_order_detail($this->sellid)['name'];            //获取客人姓名
        $phone=$order->get_order_detail($this->sellid)['phone'];          //获取客人电话
        $arrive_date=$order->get_order_detail($this->sellid)['date'];     //获取客人与大日期
        $city=$usage->MobileQueryAttribution($phone)->city;               //根据手机号获取归属地

        DB::table('wx_order_confirm')
            ->insert(['wx_openid'=>$openId,'sellid'=>$this->sellid ,'order_name'=>$name,'tel'=>$phone,
                'arrive_date'=>$arrive_date,'eventkey'=>$eventkey,'focusdate'=>$focusdate,'city'=>$city]);
    }
    
    
}
