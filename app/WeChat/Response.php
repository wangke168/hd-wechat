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


class Response{

/*    public $wechat;

    public function __construct(Application $wechat){
        $this->wechat=$wechat;
    }*/
    public function news($message,$type){
        $app = app('wechat');
        $userService = $app->user;
        $fromUsername=$userService->get($message->FromUserName)->openid;
        switch($type)
        {
            case "a":
                $text = new Text();
                $text->content = '您好！overtrue。';
//                return $app->server->serve();
                $app->staff->message($text)->to($fromUsername)->send();
                break;
            case 's':
                $news1=new News();
                $news1->title="laravel-wechat";
                $news1->description ="测试";
                $news1->url="http://www.baidu.com";
                $news1->image="http://www.hengdianworld.com/images/JQ/scenic_dy.png";
                $app->staff->message([$news1])->to('opUv9v977Njll_YHpZYMymxI_aPE')->send();
                break;
        }



/*
        $news2=new News();
        $news2->title="laravel-wechat";
        $news2->description ="测试";
        $news2->url="http://www.baidu.com";
        $news2->image="http://www.hengdianworld.com/images/JQ/scenic_dy.png";
        */

//        return $text;
//return $text;
/*        $text=new Text();
        $text->content='asdas';
        return $text;*/
//        $server=$app->server;





      /*    $server=$app->server;

        $server->setMessageHandler(function ($message) {
            $news1=new News();
            $news1->title="laravel-wechat";
            $news1->description ="测试";
            $news1->url="http://www.baidu.com";
            $news1->image="http://www.hengdianworld.com/images/JQ/scenic_dy.png";
            return $news1;
        });*/


/*        $app->server->setMessageHandler(function ($message) {
            // $message->FromUserName // 用户的 openid
            // $message->MsgType // 消息类型：event, text....
            return 'sad';
        });*/
/*        $response = $server->serve();
        return $response;*/

    }
}