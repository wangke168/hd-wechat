<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AutoSendMWT extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'AutoSendMWT';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '二销内容自动推送';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->app = app('wechat');
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
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
                    'title' => "百老舞汇",
                    'appid' => "wxd2e8a996a486b48b",
                    'pagepath' => "/pages/productDetail/productDetail?productId=23688586&dt=52882390",
                    'thumb_media_id' => "y1_Ypabgd3rcrb6YdsaJjrAaAaXBXQpcK5DHIJ8mQHja0-bHY3yj1r3BazT3XN3_",));
            $content=json_encode($minipage,JSON_UNESCAPED_UNICODE);
            $message=new Raw($content);
            $this->app->staff->message($message)->by('1001@u_hengdian')->to($send_openid->wx_openid)->send();

        }
    }
}
