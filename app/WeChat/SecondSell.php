<?php
/**
 * Created by PhpStorm.
 * User: wangke
 * Date: 16/10/17
 * Time: 下午3:52
 */

namespace App\WeChat;

use DB;
use EasyWeChat\Message\News;

class SecondSell
{

    public function second_info_send($type, $order_info,$openid)
    {

        $app=app('wechat');

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
//        return $content;

        $result=$app->staff->message($content)->by('1001@u_hengdian')->to($openid)->send();
        return $result;
    }

}