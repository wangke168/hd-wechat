<?php

namespace App\Http\Controllers;

use App\Jobs\TestQueue;
use App\Jobs\UpdateQueue;
use Illuminate\Http\Request;

use App\Http\Requests;
use DB;

class QueueController extends Controller
{
    //
    public function queue()
    {
/*       $row=DB::table('wx_click_hits')
           ->whereDate('adddate','>','2016-8-28')

           ->get();
        foreach ($row as $openid)
        {
            $this->dispatch(new TestQueue($openid));
        }*/
        $app = app('wechat');
        $token= $app->access_token->getToken();
        
        $row = DB::table('wx_user_info')
            ->where('esc', '0')
            ->where('id', '>=', '427039')
            ->orderBy('id','desc')
            ->get();
        foreach ($row as $OpenidInfo)
        {
            $this->dispatch(new UpdateQueue($OpenidInfo));
/*            $app = app('wechat');
            $token= $app->access_token->getToken();
            $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=" . $token . "&openid=" . $OpenidInfo->wx_openid;
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
                ->where('id', $OpenidInfo->id)
                ->update(['city' => $city, 'province' => $province,'country'=>$country,'subscribe_time'=>$subscribe_time]);
            DB::table('wx_user_unionid')
                ->insert(['wx_openid' => $OpenidInfo->wx_openid, 'wx_unionid' => $unionid]);*/
        }
        
        return 'Done';
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
