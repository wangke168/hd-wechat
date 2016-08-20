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
        $userService = $wechat->user;
        $wechat->server->setMessageHandler(function ($message) use ($userService) {
            switch ($message->MsgType) {
                case 'event':
                    # 事件消息...
                    break;
                case 'text':
                    $response = new Response();
                    switch ($message->Content) {
                        case 's':
                            $content= $response->news($message,"s");
                            break;
                        case 'wxh':
                            $content= $userService->get($message->FromUserName)->openid;
                            break;
                        default:
                            $content= ($response->news($message,$message->Content));
                            break;
                    }
                    return $content;
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
