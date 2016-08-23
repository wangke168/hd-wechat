<?php
/**
 * Created by PhpStorm.
 * User: 吃不胖的猪
 * Date: 2016/8/17
 * Time: 10:25
 */
namespace App\WeChat;

use EasyWeChat\Foundation\Application;
use DB;

use EasyWeChat\Message\News;
use EasyWeChat\Message\Text;
use App\Models\WechatArticle;
use App\Http\Requests;


class Response
{

    /*        public $wechat;

            public function __construct(Application $wechat){
                $this->wechat=$wechat;
            }*/
    public function news($message, $keyword)
    {

        $app = app('wechat');
        $userService = $app->user;
        $fromUsername = $userService->get($message->FromUserName)->openid;
        switch ($keyword) {
            case "a":
                $content = new Text();
                $content->content = $app->access_token->getToken();
                break;
            case 's':
                $content = new News();
                $content->title = "laravel-wechat";
                $content->description = "测试";
                $content->url = "http://www.baidu.com";
                $content->image = "http://www.hengdianworld.com/images/JQ/scenic_dy.png";
                $app->staff->message([$content])->to($fromUsername)->send();
                break;
            case 'd':
                $content = new Text();
                $usage = new usage();
                $info = $usage->get_openid_info($fromUsername);
//                $info=$this->get_openid_info($fromUsername);
                $content->content = $info->ID;
                break;
            case '天气':
                $content = new Text();
                $content->content = $this->get_weather_info();
                break;
            default:
                $row = DB::table('wx_article')
                    ->where('keyword', 'like', '%' . $keyword . '%')
                    ->where('audit', '1')
                    ->where('del', '0')
                    ->where('online', '1')
                    ->orderBy('priority', 'asc')
                    ->orderBy('id', 'desc')
                    ->skip(0)->take(8)->get();
                if ($row) {
                    $content = array();
                    foreach ($row as $result) {
                        $new = new News();
                        $new->title = $result->title;
                        $new->description = $result->description;
                        $new->url = $result->url;
                        $new->image = "http://weix2.hengdianworld.com/" . $result->picurl;
                        $content[] = $new;
                    }
                } else {
                    $content = new Text();
                    $content->content = "嘟......您的留言已经进入自动留声机，小横横回来后会努力回复你的~\n您也可以拨打400-9999141立刻接通小横横。";
                }
                break;
        }
        return $content;
    }

    public function click_request($menuID)
    {
        $row = DB::table('wx_article')
            ->where('msgtype', 'news')
            ->where('classid', $menuID)
            ->where('audit', '1')
            ->where('del', '0')
            ->where('online', '1')
            ->where('startdate', '<=', date('Y-m-d'))
            ->where('enddate', '>=', date('Y-m-d'))
            ->orderBy('eventkey', 'asc')
            ->orderBy('priority', 'asc')
            ->orderBy('id', 'desc')
            ->skip(0)->take(8)->get();
        if ($row) {
            $content = array();
            foreach ($row as $result) {
                $new = new News();
                $new->title = $result->title;
                $new->description = $result->description;
                $new->url = $result->url;
                $new->image = "http://weix2.hengdianworld.com/" . $result->picurl;
                $content[] = $new;
            }
        } else {
            $content = new Text();
            $content->content = "嘟......您的留言已经进入自动留声机，小横横回来后会努力回复你的~\n您也可以拨打400-9999141立刻接通小横横。";
        }
        return $content;
    }

    private function get_weather_info()
    {
        $json = file_get_contents("http://api.map.baidu.com/telematics/v3/weather?location=%E4%B8%9C%E9%98%B3&output=json&ak=2c87d6d0443ab161753291258ac8ab7a");
        $data = json_decode($json, true);
        $contentStr = "【横店天气预报】：\n\n";
        $contentStr = $contentStr . $data['results'][0]['weather_data'][0]['date'] . "\n";
        $contentStr = $contentStr . "天气情况：" . $data['results'][0]['weather_data'][0]['weather'] . "\n";
        $contentStr = $contentStr . "气温：" . $data['results'][0]['weather_data'][0]['temperature'] . "\n\n";
        $contentStr = $contentStr . "明天：" . $data['results'][0]['weather_data'][1]['date'] . "\n";
        $contentStr = $contentStr . "天气情况：" . $data['results'][0]['weather_data'][1]['weather'] . "\n";
        $contentStr = $contentStr . "气温：" . $data['results'][0]['weather_data'][1]['temperature'] . "\n\n";
        $contentStr = $contentStr . "后天：" . $data['results'][0]['weather_data'][2]['date'] . "\n";
        $contentStr = $contentStr . "天气情况：" . $data['results'][0]['weather_data'][2]['weather'] . "\n";
        $contentStr = $contentStr . "气温：" . $data['results'][0]['weather_data'][2]['temperature'] . "\n";
        return $contentStr;
    }

    private function get_openid_info($openid)
    {
        $row = DB::table('wx_user_info')
            ->where('wx_openid', $openid)
            ->first();
        return $row;
    }
}