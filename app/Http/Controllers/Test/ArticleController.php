<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use App\WeChat\Count;
use App\WeChat\Order;
use App\WeChat\SecondSell;
use App\WeChat\Usage;
use Carbon\Carbon;
use EasyWeChat\Message\News;
use EasyWeChat\Message\Text;
use EasyWeChat\Support\Str;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests;

class ArticleController extends Controller
{


    public function test()
    {
        $openid='d3228mRSj4ObBLjaMl0zjGNcZOK7k8N7TZXRu7DEFIgoKi8zBaRM6RKiUSLIGmDHJ9SoqCEz[a]TkA';
        $sellid='V1611220022';
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
   //     $city = $usage->MobileQueryAttribution($phone)->city;               //根据手机号获取归属地

        DB::table('wx_order_confirm')
            ->insert(['wx_openid' => $openId, 'sellid' => $sellid, 'order_name' => $name, 'tel' => $phone,
                'arrive_date' => $arrive_date, 'eventkey' => $eventkey, 'focusdate' => $focusdate]);
    }


    public function time_test()
    {
        $usage = new Usage();
        return $usage->authcode('o2e-dyh', 'ENCODE', 0);


    }

    private function get_second_info()
    {

    }

    private function get_second_info_public()
    {
        $row = DB::table('se_info_detail')
            ->where('online', '1')
            ->where('is_all', '1')
            ->orderBy('id', 'desc')
            ->get();

    }

    private function second_info_send($type, $order_info)
    {


        $rows = DB::table('se_info_detail')
            ->where('online', '1')
            ->where('is_all', '1')
            ->orderBy('id', 'desc')
            ->get();
        foreach ($rows as $row) {
            $news = new News();
            $news->title = $row->title;
            $news->description = $row->description;
            $news->url = $row->article_url;
            $news->image = $row->pic_url;
            $content[] = $news;
        }

        switch ($type) {
            case 'ticket':
                $rows = DB::table('se_info_detail')
                    ->where('online', '1')
                    ->where('is_all', '0')
                    ->orderBy('id', 'desc')
                    ->get();
                foreach ($rows as $row) {
                    if (strpos($order_info, $row->zone) !== false) {
                        $news = new News();
                        $news->title = $row->title;
                        $news->description = $row->description;
                        $news->url = $row->article_url;
                        $news->image = $row->pic_url;
                        $content[] = $news;
                    }
                }
                break;
            case 'inclusive':
                $rows = DB::table('se_info_detail')
                    ->where('online', '1')
                    ->where('is_all', '0')
                    ->orderBy('id', 'desc')
                    ->get();
                foreach ($rows as $row) {
                    if ($row->zone) {
                        if (strpos($order_info, $row->zone) !== false) {
                            $news = new News();
                            $news->title = $row->title;
                            $news->description = $row->description;
                            $news->url = $row->article_url;
                            $news->image = $row->pic_url;
                            $content[] = $news;
                        }
                    }
                    if (strpos($order_info, $row->hotel) !== false) {
                        $news = new News();
                        $news->title = $row->title;
                        $news->description = $row->description;
                        $news->url = $row->article_url;
                        $news->image = $row->pic_url;
                        $content[] = $news;
                    }
                }

                break;
            case
            'hotel':
                $rows = DB::table('se_info_detail')
                    ->where('online', '1')
                    ->where('is_all', '0')
                    ->orderBy('id', 'desc')
                    ->get();
                foreach ($rows as $row)
                    if (strpos($order_info, $row->hotel) !== false) {
                        $news = new News();
                        $news->title = $row->title;
                        $news->description = $row->description;
                        $news->url = $row->article_url;
                        $news->image = $row->pic_url;
                        $content[] = $news;
                    }
                break;
        }
        return $content;

    }


}
