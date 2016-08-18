<?php

namespace App\Http\Controllers;
use App\WeChat\Response;
use EasyWeChat\Message\Text;
use EasyWeChat\Message\News;
use Illuminate\Http\Request;

use App\Http\Requests;

class WechatController extends Controller
{

    public function serve()
    {
//        Log::info('request arrived.'); # 注意：Log 为 Laravel 组件，所以它记的日志去 Laravel 日志看，而不是 EasyWeChat 日志

        $wechat = app('wechat');
        $userApi = $wechat->user;
        $wechat->server->setMessageHandler(function ($message) use ($userApi){
            switch ($message->MsgType) {
                case 'event':
                    # 事件消息...
                    break;
                case 'text':
//                    return 'hello'.$userApi->get($message->FromUserName)->openid;

           /*         $text = new Text();
                    $text->content = '您好！overtrue。';
                    return $text;*/
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
                    return [$news1,$news2];
                    break;
                case 'image':
                    # 图片消息...
                    break;
                case 'voice':
                    # 语音消息...
                    break;
                case 'video':
                    # 视频消息...
                    break;
                case 'location':
                    # 坐标消息...
                    break;
                case 'link':
                    # 链接消息...
                    break;
                // ... 其它消息
                default:
                    # code...
                    break;
            }
        });

//        Log::info('return response.');

        return $wechat->server->serve();
    }
}