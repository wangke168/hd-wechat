<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use DB;

class UpdateOpenidQueue extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    public $OpenidInfo;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($OpenidInfo)
    {
        $this->OpenidInfo = $OpenidInfo;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $app = app('wechat');
        $token = $app->access_token->getToken();
        $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=" . $token . "&openid=" . $this->OpenidInfo->wx_openid;
        $json = $this->http_request_json($url);//这个地方不能用file_get_contents
        $data = json_decode($json, true);

//            $nickname = $data['nickname'];
//            $sex = $data['sex'];
        $city = $data['city'];
        $province = $data['province'];
        $country = $data['country'];
        $subscribe_time = $data['subscribe_time'];
        $unionid = $data['unionid'];

        DB::table('wx_user_info')
            ->where('id', $this->OpenidInfo->id)
            ->update(['city' => $city, 'province' => $province, 'country' => $country, 'subscribe_time' => $subscribe_time]);
        DB::table('wx_user_unionid')
            ->insert(['wx_openid' => $this->OpenidInfo->wx_openid, 'wx_unionid' => $unionid]);
//            Log::info($result->wx_openid);
    }

    //因为url是https 所有请求不能用file_get_contents,用curl请求json 数据
    private function http_request_json($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
}
