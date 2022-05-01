<?php

namespace App\Http\Controllers;

use App\WeChat\Response;
use App\WeChat\Tour;
use EasyWeChat\Message\Text;
use EasyWeChat\Message\News;
use EasyWeChat\Message\Voice;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests;

class WechatController extends Controller
{

    public function serve()
    {
//        Log::info('request arrived.'); # 注意：Log 为 Laravel 组件，所以它记的日志去 Laravel 日志看，而不是 EasyWeChat 日志

        $wechat = app('wechat');
        $userService = $wechat->user;

        $wechat->server->setMessageHandler(function ($message) use ($userService) {
            $openid = $userService->get($message->FromUserName)->openid;
            $eventkey = $message->EventKey;
            $response = new Response();
            switch ($message->MsgType) {
                case 'event':
                    # 事件消息...
                    switch ($message->Event) {
                        case 'CLICK':
                            switch ($message->EventKey) {
                                case "100":
                                    $content = new Text();
                                    $content->content = "官方客服电话" . "\n" . "4009057977";
                                    return $content;
                                case "200":
                                    $content = new Text();
                                    $content->content = "米友圈专享特惠横店影视城门票将于后续上线，敬请期待。";
                                    return $content;
                                default:
                                    $response->click_request($openid, $message->EventKey);
                                    break;
                            }
                            break;
                        case 'subscribe':
                            #关注事件
                            $eventkey = $message->EventKey;
                            //检查是不是酒店会员中心的分销二维码，如果是，转成
                            if (strlen($eventkey) >= 15) {
                                $eventkey = "qrscene_1007";
                            }
                            if (substr($eventkey, 0, 7) == 'qrscene') {
                                $eventkey = substr($eventkey, 8);
                            } else {
                                $eventkey = "";
//                                $eventkey = $response->check_openid_wificonnected($openid);
                            }
                            $response->insert_subscribe($openid, $eventkey, 'subscribe'); //更新openid信息
                            $response->make_user_tag($openid, $eventkey); //标签管理
                            $response->request_focus($openid, $eventkey); //推送关注信息

                            //    $response->request_focus_temp($openid, $eventkey); //黄金周景区预定推送


                            break;
                        case 'SCAN':
                            #重复关注事件
                            $eventkey = $message->EventKey;
                            if (strlen($eventkey) >= 15) {
                                $eventkey = "1007";
                            }
                            if ($eventkey == "1336") {
                                $tour = new Tour();
                                $content = new Text();
                                $content->content = $tour->verification_subscribe($openid, '1');
                                return $content;

                            } else {
                                $response->insert_subscribe($openid, $eventkey, 'scan'); //更新openid信息
                                $response->make_user_tag($openid, $eventkey); //标签管理
                                $response->request_focus($openid, $eventkey); //推送关注信息


                                //      $response->request_focus_temp($openid, $eventkey); //黄金周景区预定推送


                            }
                            break;
                        case 'unsubscribe':
                            #取消关注事件
                            $response->insert_unsubscribe($openid); //更新数据信息

                            break;
                        case 'WifiConnected':
                            #wifi连接事件
                            $response->return_WifiConnected($message);

                            break;
                    }
                    break;
                case 'text':
                    //把内容加入wx_recevice_txt
                    DB::table('wx_recevice_txt')
                        ->insert(['wx_openid' => $openid, 'content' => $message->Content]);
                    $response->request_keyword($openid, $eventkey, $message->Content);
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
