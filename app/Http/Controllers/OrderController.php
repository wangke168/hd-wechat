<?php

namespace App\Http\Controllers;

use EasyWeChat\Foundation\Application;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests;

class OrderController extends Controller
{
    //
    public $app;
    public $notice;

    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->notice = $app->notice;
    }

    public function send($openid, $sellid)
    {
        return $this->Repost_order($openid, $sellid);
    }

    private function test()
    {
        $userId = 'opUv9v977Njll_YHpZYMymxI_aPE';
        $templateId = 'SHuJTADBgVyIrGlpFgM2NY9ec84UOXqfxfoGsLy17DI';
        $url = 'http://weix2.hengdianworld.com/article/articledetail.php?id=44';
        $color = '#FF0000';
        $data = array(
            "first" => array("恭喜你购买成功！", "#000000"),
            "keyword1" => array("巧克力", "#173177"),
            "keyword2" => array("39.8元", "#173177"),
            "keyword3" => array("39.8元", "#173177"),
            "keyword4" => array("39.8元", "#173177"),
            "keyword5" => array("39.8元", "#173177"),
            "remark" => array("欢迎再次购买！", "#000000"),
        );


        $result = $this->notice->uses($templateId)->withUrl($url)->andData($data)->andReceiver($userId)->send();
        var_dump($result);
    }

    private function Repost_order($openid, $sellid)
    {
        $userId = $openid;
        $url = 'http://weix2.hengdianworld.com/article/articledetail.php?id=44';
        $color = '#FF0000';

        $ticket_id = "";
        $hotel = "";

        $json = file_get_contents("http://e.hengdianworld.com/searchorder_json.aspx?sellid=" . $sellid);
        $data = json_decode($json, true);


        $ticketcount = count($data['ticketorder']);
        $inclusivecount = count($data['inclusiveorder']);
        $hotelcount = count($data['hotelorder']);

        $i = 0;
        if ($ticketcount <> 0) {
            $ticket_id = 1;
            for ($j = 0; $j < $ticketcount; $j++) {
                $i = $i + 1;
                $name = $data['ticketorder'][$j]['name'];
                $first = $data['ticketorder'][$j]['name'] . "，您好，您已经成功预订门票。\n";
                $sellid = $data['ticketorder'][$j]['sellid'];
                $date = $data['ticketorder'][$j]['date2'];
                $ticket = $data['ticketorder'][$j]['ticket'];
                $numbers = $data['ticketorder'][$j]['numbers'];

                $flag = $data['ticketorder'][$j]['flag'];

                if ($flag == "未支付" || $flag == "已取消") {
                    break;
                }

                if ($data['ticketorder'][$j]['ticket'] == '三大点+梦幻谷' || $data['ticketorder'][$j]['ticket'] == '网络联票+梦幻谷') {
                    $ticketorder = "注意：该票种需要身份证检票";
                } else {
                    $ticketorder = $data['ticketorder'][$j]['code'];
                }


                $remark = "\n在检票口出示此识别码可直接进入景区。\n如有疑问，请致电4009999141。";

                $templateId = 'SHuJTADBgVyIrGlpFgM2NY9ec84UOXqfxfoGsLy17DI';
                $data = array(
                    "first" => array($first, "#000000"),
                    "keyword1" => array($sellid, "#173177"),
                    "keyword2" => array($date, "#173177"),
                    "keyword3" => array($ticket, "#173177"),
                    "keyword4" => array($numbers, "#173177"),
                    "keyword5" => array($ticketorder, "#173177"),
                    "remark" => array($remark, "#000000"),
                );

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

                $templateId = '1QHtqCEjUWyWL26hnLMnJ7GFI5-0kVOLEcxfmJR3wms';
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

                $templateId = 'jXTW9HWSE_oighJr9L940ZG-HCkrI84onzdk5s0b9hs';
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



        /*       $db->query("insert into wx_order_detail (sellid,wx_openid,k_name,arrivedate,ticket_id,ticket,hotel) VALUES (:sellid,:wx_openid,:k_name,:arrivedate,:ticket_id,:ticket,:hotel)",
                   array("sellid" => "$sellid", "wx_openid" => "$openid", "k_name" => $name, "arrivedate" => "$date", "ticket_id" => "$ticket_id", "ticket" => "$ticket", "hotel" => "$hotel"));*/

//        return $xjson;

    }
}
