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
use App\Models\WechatArticle;
use App\Http\Requests;


class Response{

    public $wechat;
    public function __construct(Application $wechat)
    {
        $this->wechat=$wechat;
    }

    public function news(){



       $news1=new News();
        $news1->title="laravel-wechat";
        $news1->description ="测试";
        $news1->url="http://www.baidu.com";
        $news1->image="http://www.hengdianworld.com/images/JQ/scenic_dy.png";

        $news2=new News();
        $news2->title="laravel-wechat";
        $news2->description ="测试";
        $news2->url="http://www.baidu.com";
        $news2->image="http://www.hengdianworld.com/images/JQ/scenic_dy.png";
//        return [$news1];
        $this->wechat->server->setMessageHandler(function ($message) {
            // $message->FromUserName // 用户的 openid
            // $message->MsgType // 消息类型：event, text....
            return "您好！欢迎关注我!";
        });
/*        $app=app('wechat');
//        $app = new Application($options);
// 从项目实例中得到服务端应用实例。
        $server = $app->server;
        $server->setMessageHandler(function ($message) {
            // $message->FromUserName // 用户的 openid
            // $message->MsgType // 消息类型：event, text....
            return "您好！欢迎关注我!";
        });
        $response = $server->serve();
        return $response;*/

    }
}