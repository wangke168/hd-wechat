<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use App\WeChat\SecondSell;
use EasyWeChat\Message\News;
use EasyWeChat\Message\Text;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests;

class ArticleController extends Controller
{


    public function test()
    {/*
        $app=app('wechat');
        $openid='opUv9v977Njll_YHpZYMymxI_aPE';
        $Second=new SecondSell();
        $news= $Second->second_info_send('hotel', '明清宫苑+梦幻谷+贵宾楼',$openid,'asdafds');

        return $news;*/
        return $_SERVER['HTTP_HOST'];

//        return $content;
/*
        $content = new News();
        $content->title = "laravel-wechat";
        $content->description = "测试";
        $content->url = "http://blog.unclewang.me/zone/subscribe/ldjl/asdass/";
        $content->image = "http://www.hengdianworld.com/images/JQ/scenic_dy.png";
        $aaaa[]=$content;
//        return $aaaa;
          $result=$app->staff->message($aaaa)->by('1001@u_hengdian')->to($openid)->send();
        return $result;*/
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
