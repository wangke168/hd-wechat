<?php

namespace App\Jobs;

use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use EasyWeChat\Message\Text;
class SendSecondQueue extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    public $openid;
    public $app;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($openid)
    {
        //
        $this->openid = $openid;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $this->app = app('wechat');
        $content = new Text();
        $content->content = "您好，现在横店影视城推出升级成横店畅游年卡，已购门票抵现金的活动，从您购买开始全年365天均可游玩，同时您的门票费用可直接抵现金，最高可减550元，<a href='https://hdwechat.hengdianworld.com/jump?id=1551'>点击查看详情</a>。";
        $this->app->staff->message($content)->by('1001@u_hengdian')->to($this->openid)->send();
        \Log::info('年卡信息已发送'.$this->openid);
    }
}
