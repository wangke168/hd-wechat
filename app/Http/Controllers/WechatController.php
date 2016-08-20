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
            $response = new Response();
            switch ($message->MsgType) {
                case 'event':
                    # 事件消息...
                    switch ($message->Event) {
                        case 'click':
                            switch ($message->Eventkey) {
                                case "2":
                                    $content = $response->click_request("2");
                                    return $content;
                                    break;
                                case "13":
                                    $content = new Text();
                                    $content->content = "横店影视城官方客服电话" . "\n" . "400-9999141";
                                    return $content;
                            }
                            break;
                        case 'subscribe':
                            #关注事件
                            break;
                        case 'SCAN':
                            #重复关注事件
                            break;
                        case 'unsubscribe':
                            #取消关注事件
                            break;
                        case 'WifiConnected':
                            #wifi连接事件
                            break;
                    }
                    break;
                case 'text':

                    switch ($message->Content) {
                        case 's':
                            $response->news($message, "s");
                            break;
                        case 'wxh':
                            $content = $userService->get($message->FromUserName)->openid;
                            return $content;
                            break;
                        default:
                            $content = ($response->news($message, $message->Content));
                            return $content;
                            break;
                    }
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
