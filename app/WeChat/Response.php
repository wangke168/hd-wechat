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
                $app->staff->message($text)->to($fromUsername)->send();
                break;
            case 's':
                $news1 = new News();
                $news1->title = "laravel-wechat";
                $news1->description = "测试";
                $news1->url = "http://www.baidu.com";
                $news1->image = "http://www.hengdianworld.com/images/JQ/scenic_dy.png";
                $app->staff->message([$news1])->to($fromUsername)->send();
                break;
            case 'd':
                $text = new Text();
                $text->content = 'Hello World。';
                return $text;
                break;
            default:

                $row=DB::table('wx_article')->where('title','like','门票%')->orderBy('id','desc')->skip(0)->take(1)->get();
                $i=1;
                foreach ($row as $result) {
                    $news.$i = new News();
                    $news.$i->title = $result->title;
                    $news.$i->description = $result->description;
                    $news.$i->url = $result->url;
                    $news.$i->image = $result->picurl;
                }
                return [$news1];
                break;
        }
    }
}