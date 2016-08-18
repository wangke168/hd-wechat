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

        return 'asdas';
//        $server=$app->server;

/*        $app = app('wechat');

        $app->server->setMessageHandler(function ($message) {
            // $message->FromUserName // 用户的 openid
            // $message->MsgType // 消息类型：event, text....
            return 'sad';
        });*/
/*        $response = $server->serve();
        return $response;*/

    }
}