<?php
/**
 * Created by PhpStorm.
 * User: wangke
 * Date: 16-9-24
 * Time: 上午9:12
 */

namespace App\WeChat;

//和订单有关的类
class Order
{
    /**
     * 根据订单号查询信息
     * @param $sellid ：订单号
     *
     */
    public function get_order_detail($sellid)
    {
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
                $date = $data['ticketorder'][$j]['date2'];
                $ticket = $data['ticketorder'][$j]['ticket'];
                $numbers = $data['ticketorder'][$j]['numbers'];
                $ticketorder = $data['ticketorder'][$j]['ticket'];
                $flag = $data['ticketorder'][$j]['flag'];

                if ($flag == "未支付" || $flag == "已取消") {
                    break;
                }
                $result = array(
                    "ticket_id" => $ticket_id,
                    "name" => $name,
                    "sellid" => $sellid,
                    "date" => $date,
                    "ticket" => $ticket,
                    "numbers" => $numbers,
                    "ticketorder" => $ticketorder,
                );
            }
        }
        if ($inclusivecount <> 0) {
            $ticket_id = 2;
            for ($j = 0; $j < $inclusivecount; $j++) {
                $i = $i + 1;
                $name = $data['inclusiveorder'][$j]['name'];
                $date = $data['inclusiveorder'][$j]['date2'];
                $ticket = $data['inclusiveorder'][$j]['ticket'];
                $hotel = $data['inclusiveorder'][$j]['hotel'];
                $flag = $data['inclusiveorder'][$j]['flag'];

                if ($flag == "未支付" || $flag == "已取消") {
                    break;
                }

                $result = array(
                    "ticket_id" => $ticket_id,
                    "name" => $name,
                    "sellid" => $sellid,
                    "date" => $date,
                    "ticket" => $ticket,
                    "hotel" => $hotel,
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

                $result = array(
                    "ticket_id" => $ticket_id,
                    "name" => $name,
                    "sellid" => $sellid,
                    "date" => $date,
                    "days" => $days,
                    "hotel" => $hotel,
                    "numbers" => $numbers,
                    "roomtype" => $roomtype,

                );

            }

        }
        return $result;
    }


}