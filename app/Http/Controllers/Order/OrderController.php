<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Jobs\ConfrimOrderQueue;
use App\Jobs\SendOrderQueue;
use App\WeChat\SecondSell;
use App\WeChat\Usage;
use EasyWeChat\Foundation\Application;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\WeChat\Order;
use EasyWeChat\Message\News;

class OrderController extends Controller
{
    //
    public $app;
    public $notice;

//    public $usage;

    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->notice = $app->notice;
//        $this->usage = new Usage();
    }

    public function send($sellid, $openid)
    {
        if ($this->check_order($sellid)) {
//            $this->dispatch(new SendOrderQueue($sellid,$openid));
            $this->insert_order($openid, $sellid);
            $this->Repost_order($openid, $sellid);
        }
    }

    public function confrim($sellid, $openid = null)
    {
//        $this->dispatch(new ConfrimOrderQueue($sellid,$openid));
        $usage = new Usage();
        $order = new Order();

        $eventkey = '';
        $focusdate = '';

        $openId = $usage->authcode($openid, 'DECODE', 0);
        if ($usage->get_openid_info($openId)) {
            $eventkey = $usage->get_openid_info($openId)->eventkey;     //获取客人所属市场
            $focusdate = $usage->get_openid_info($openId)->adddate;     //获取客人关注时间
        }

        $name = $order->get_order_detail($sellid)['name'];            //获取客人姓名
        $phone = $order->get_order_detail($sellid)['phone'];          //获取客人电话
        $arrive_date = $order->get_order_detail($sellid)['date'];     //获取客人与大日期
        $city = $usage->MobileQueryAttribution($phone)->city;               //根据手机号获取归属地

        DB::table('wx_order_confirm')
            ->insert(['wx_openid' => $openId, 'sellid' => $sellid, 'order_name' => $name, 'tel' => $phone,
                'arrive_date' => $arrive_date, 'eventkey' => $eventkey, 'focusdate' => $focusdate, 'city' => $city]);
    }


    private function check_order($sellid)
    {
        $row = DB::table('wx_order_send')
            ->where('sellid', $sellid)
            ->count();

        if ($row == 0) {
            $flag = true;
        } else {
            $flag = false;
        }
        return $flag;
    }

    private function insert_order($openid, $sellid)
    {
        $usage = new Usage();
        if ($usage->get_openid_info($openid)) {
            $eventkey = $usage->get_openid_info($openid)->eventkey;
            $focusdate = $usage->get_openid_info($openid)->adddate;
        }
        DB::table('wx_order_send')
            ->insert(['wx_openid' => $openid, 'sellid' => $sellid, 'eventkey' => $eventkey, 'focusdate' => $focusdate]);

    }

    private function Repost_order($openid, $sellid)
    {
        $second = new SecondSell();
//        $app = app('wechat');
//        $notice = $app->notice;
        $userId = $openid;
        $url = 'http://weix2.hengdianworld.com/article/articledetail.php?id=44';
        $color = '#FF0000';

        $ticket_id = "";
        $hotel = "";
        $ticket = "";
        $json = file_get_contents("http://e.hengdianworld.com/searchorder_json.aspx?sellid=" . $sellid);
        $data = json_decode($json, true);

        $ticketcount = count($data['ticketorder']);
        $inclusivecount = count($data['inclusiveorder']);
        $hotelcount = count($data['hotelorder']);

        $i = 0;
        if ($ticketcount <> 0) {
            $ticket_id = 1;
//            for ($j = 0; $j < $ticketcount; $j++) {
//                $i = $i + 1;
            $name = $data['ticketorder'][0]['name'];
            $first = $data['ticketorder'][0]['name'] . "，您好，您已经成功预订门票。\n";
            $sellid = $data['ticketorder'][0]['sellid'];
            $date = $data['ticketorder'][0]['date2'];
            $ticket = $data['ticketorder'][0]['ticket'];
            $numbers = $data['ticketorder'][0]['numbers'];

            $flag = $data['ticketorder'][0]['flag'];

            if ($flag != "未支付" && $flag != "已取消") {
//                break;


                if ($data['ticketorder'][0]['ticket'] == '三大点+梦幻谷' || $data['ticketorder'][0]['ticket'] == '网络联票+梦幻谷') {
                    $ticketorder = "注意：该票种需要身份证检票";
                } else {
                    $ticketorder = $data['ticketorder'][0]['code'];
                }

                $remark = "\n在检票口出示此识别码可直接进入景区。\n如有疑问，请致电4009999141。";

                $templateId = env('TEMPLATEID_TICKET');

                $data = array(
                    "first" => array($first, "#000000"),
                    "keyword1" => array($sellid, "#173177"),
                    "keyword2" => array($date, "#173177"),
                    "keyword3" => array($ticket, "#173177"),
                    "keyword4" => array($numbers, "#173177"),
                    "keyword5" => array($ticketorder, "#173177"),
                    "remark" => array($remark, "#000000"),
                );

                $content[] = $second->second_info_send('ticket', $ticket);

            }
        }
        if ($inclusivecount <> 0) {
            $ticket_id = 2;
            for ($j = 0; $j < $inclusivecount; $j++) {
                $i = $i + 1;
                $first = $data['inclusiveorder'][$j]['name'] . "，您好，您已经成功预订组合套餐。\n";
                $sellid = $data['inclusiveorder'][$j]['sellid'];
                $name = $data['inclusiveorder'][$j]['name'];
                $date = $data['inclusiveorder'][$j]['date2'];
                $ticket = $data['inclusiveorder'][$j]['ticket'];
                $hotel = $data['inclusiveorder'][$j]['hotel'];
                $flag = $data['inclusiveorder'][$j]['flag'];

                if ($flag == "未支付" || $flag == "已取消") {
                    break;
                }

                $remark = "人数：" . $data['inclusiveorder'][$j]['numbers'] . "\n\n预达日凭身份证到酒店前台取票。如有疑问，请致电4009999141。";

                $templateId = env('TEMPLATEID_PACKAGES');

                $data = array(
                    "first" => array($first, "#000000"),
                    "keyword1" => array($sellid, "#173177"),
                    "keyword2" => array($name, "#173177"),
                    "keyword3" => array($date, "#173177"),
                    "keyword4" => array($ticket, "#173177"),
                    "keyword5" => array($hotel, "#173177"),
                    "remark" => array($remark, "#000000"),
                );

            }
        }
        if ($hotelcount <> 0) {
            $ticket_id = 3;
            for ($j = 0; $j < $hotelcount; $j++) {
                $i = $i + 1;
                $sellid = $data['hotelorder'][$j]['sellid'];
                $name = $data['hotelorder'][$j]['name'];
                $date = $data['hotelorder'][$j]['date2'];
                $days = $data['hotelorder'][$j]['days'];
                $hotel = $data['hotelorder'][$j]['hotel'];
                $numbers = $data['hotelorder'][$j]['numbers'];
                $roomtype = $data['hotelorder'][$j]['roomtype'];
                $flag = $data['hotelorder'][$j]['flag'];

                if ($flag == "未支付" || $flag == "已取消") {
                    break;
                }
                $first = "        " . $name . "，您好，您已经成功预订" . $hotel . "，酒店所有工作人员静候您的光临。\n";
                $remark = "\n        预达日凭身份证到酒店前台办理入住办手续。\n如有疑问，请致电4009999141。";

                $templateId = env('TEMPLATEID_HOTEL');

                $data = array(
                    "first" => array($first, "#000000"),
                    "keyword1" => array($sellid, "#173177"),
                    "keyword2" => array($date, "#173177"),
                    "keyword3" => array($days, "#173177"),
                    "keyword4" => array($roomtype, "#173177"),
                    "keyword5" => array($numbers, "#173177"),
                    "remark" => array($remark, "#000000"),
                );

            }
        }


        DB::table('wx_order_detail')
            ->insert(['sellid' => $sellid, 'wx_openid' => $openid, 'k_name' => $name,
                'arrivedate' => $date, 'ticket_id' => $ticket_id, 'ticket' => $ticket,
                'hotel' => $hotel]);

        $this->notice->uses($templateId)->withUrl($url)->andData($data)->andReceiver($userId)->send();

        $this->app->staff->message($content)->by('1001@u_hengdian')->to($openid)->send();
    }
}
