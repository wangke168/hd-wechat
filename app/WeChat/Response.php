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

    /*    public $wechat;

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
                $text = new Text();
                $text->content = '您好！overtrue。';
                return $text;
//                $app->staff->message($text)->to($fromUsername)->send();
                break;
            case 's':
                $news1 = new News();
                $news1->title = "laravel-wechat";
                $news1->description = "测试";
                $news1->url = "http://www.baidu.com";
                $news1->image = "http://www.hengdianworld.com/images/JQ/scenic_dy.png";
//                $app->staff->message([$news1])->to($fromUsername)->send();
                break;
            case '天气':
                $text=new Text();
                $text->content=$this->get_weather_info();
                return $text;
                break;
            default:
                $row = DB::table('wx_article')->where('title', 'like', '%门票%')->orderBy('id', 'desc')->skip(0)->take(8)->get();
                $news=array();
                foreach ($row as $result) {
                    $new = new News();
                    $new->title = $result->title;
                    $new->description = $result->description;
                    $new->url = $result->url;
                    $new->image = $result->picurl;
                    $news[]=$new;
                }
                return $news;
                break;
        }
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

}