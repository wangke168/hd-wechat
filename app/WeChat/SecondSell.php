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

    public function second_info_send($type, $order_info, $openid, $sellid)
    {

        $usage = new Usage();
        $wxnumber = $usage->authcode($openid, 'ENCODE', 0);

       /* $rows = DB::table('wx_article_se')
            ->where('online', '1')
            ->where('target', '1')
            ->whereDate('startdate', '<=', date('Y-m-d'))
            ->whereDate('enddate', '>=', date('Y-m-d'))
            ->orderBy('priority', 'asc')
            ->get();
        foreach ($rows as $row) {
            $news = new News();
            $news->title = $row->title;
            $news->description = $row->description;

            if ($row->url) {
                $url = $row->url;
            } else {
                $url = "http://" . $_SERVER['HTTP_HOST'] . "/article/detail?action=se&id=" . $row->id . "&wxnumber=" . $openid;
            }
            $news->url = $url;
            $news->image = $row->pic_url;
            $content[] = $news;
            $info_ids[] = $row->id;
        }*/

        switch ($type) {
            case 'ticket':
                $rows = DB::table('wx_article_se')
                    ->where('online', '1')
                    ->whereIn('target', [1,2])
                    ->orderBy('priority', 'asc')
                    ->get();
                foreach ($rows as $row) {
                    $news = new News();
                    $news->title = $row->title;
                    $news->description = $row->description;
                    $pic_url = 'http://weix2.hengdianworld.com/' . $row->pic_url;
                    if ($row->url) {
                        $url = $row->url;
                    } else {
                        $url = "http://" . $_SERVER['HTTP_HOST'] . "/article/detail?type=se&sellid=".$sellid."&id=" . $row->id . "&wxnumber=" . $wxnumber;
                    }
                    $news->url = $url;
                    $news->image = $pic_url;
                    $content[] = $news;
                    $info_ids[] = $row->id;
                }
                break;
        }

        //     $url='http://'.$_SERVER['SERVER_NAME'].'/secondarticle/'.$sellid.'/'.$openid_article.'/';

        /*        $rows = DB::table('se_info_detail')
                    ->where('online', '1')
                    ->where('is_all', '1')
                    ->orderBy('sequence', 'asc')
                    ->get();
                foreach ($rows as $row) {
                    $news = new News();
                    $news->title = $row->title;
                    $news->description = $row->description;
        //            $news->url = $row->article_url;
                    $news->url=$url.$row->id;
                    $news->image = $row->pic_url;
                    $content[] = $news;
                    $info_ids[]=$row->id;
                }*/

       /* switch ($type) {
            case 'ticket':
                $rows = DB::table('se_info_detail')
                    ->where('online', '1')
                    ->where('is_all', '0')
                    ->orderBy('sequence', 'asc')
                    ->get();
                foreach ($rows as $row) {
                    if ($row->zone) {
                        if (strpos($order_info, $row->zone) !== false) {
                            $news = new News();
                            $news->title = $row->title;
                            $news->description = $row->description;
//                            $news->url = $row->article_url;
                            $news->url = $url . $row->id;
                            $news->image = $row->pic_url;
                            $content[] = $news;
                            $info_ids[] = $row->id;
                        }
                    }
                }
                break;
            case 'inclusive':
                $rows = DB::table('se_info_detail')
                    ->where('online', '1')
                    ->where('is_all', '0')
                    ->orderBy('sequence', 'asc')
                    ->get();
                foreach ($rows as $row) {
                    if ($row->zone) {
                        if (strpos($order_info, $row->zone) !== false) {
                            $news = new News();
                            $news->title = $row->title;
                            $news->description = $row->description;
//                            $news->url = $row->article_url;
                            $news->url = $url . $row->id;
                            $news->image = $row->pic_url;
                            $content[] = $news;
                            $info_ids[] = $row->id;
                        }
                    }
                    if ($row->hotel) {
                        if (strpos($order_info, $row->hotel) !== false) {
                            $news = new News();
                            $news->title = $row->title;
                            $news->description = $row->description;
//                            $news->url = $row->article_url;
                            $news->url = $url . $row->id;
                            $news->image = $row->pic_url;
                            $content[] = $news;
                            $info_ids[] = $row->id;
                        }
                    }
                }

                break;
            case
            'hotel':
                $rows = DB::table('se_info_detail')
                    ->where('online', '1')
                    ->where('is_all', '0')
                    ->orderBy('sequence', 'asc')
                    ->get();
                foreach ($rows as $row)
                    if ($row->hotel) {
                        if (strpos($order_info, $row->hotel) !== false) {
                            $news = new News();
                            $news->title = $row->title;
                            $news->description = $row->description;
//                            $news->url = $row->article_url;
                            $news->url = $url . $row->id;
                            $news->image = $row->pic_url;
                            $content[] = $news;
                            $info_ids[] = $row->id;
                        }
                    }
                break;
        }*/

        foreach ($info_ids as $info_id) {
            DB::table('se_info_send')
                ->insert(['wx_openid' => $openid, 'sellid' => $sellid, 'info_id' => $info_id]);
        }

        return $content;

    }

}