<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use EasyWeChat\Message\Text;
use Illuminate\Console\Command;
use DB;
class AutoRemindLdjl extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'AutoRemindLdjl';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'AutoRemindLdjl';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $app=app('wechat');
        
        $project_id="1";

//        $starttime=strtotime(date("Y-m-d H:i:s", time() - 3600));

        $endtime=strtotime(date("Y-m-d H:i:s", time() + 1200));

        $content = new Text();

/*        $row=$db->query("select * from tour_project_wait_detail WHERE project_id=:project_id AND used=:used AND date(addtime)=:adddate AND UNIX_TIMESTAMP(addtime)>=:starttime AND UNIX_TIMESTAMP(addtime)<:endtime",
            array("project_id"=>$project_id,"used"=>"0","adddate"=>date("Y-m-d"),"starttime"=>$starttime,"endtime"=>$endtime));*/
        
        $row=DB::table('tour_project_wait_detail')
            ->where('project_id',$project_id)
            ->where('used',0)
            ->where('verification_time','>',Carbon::now())
            ->whereRaw('UNIX_TIMESTAMP(verification_time)<=' . $endtime)
            ->get();
        foreach ($row as $send_openid) 
        {
            $content->content="您在龙帝惊临预约时间即将到时，请合理安排您的游玩时间。";
            $app->staff->message($content)->by('1001@u_hengdian')->to($send_openid->wx_openid)->send();

        }
    }
}
