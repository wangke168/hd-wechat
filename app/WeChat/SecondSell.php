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

    public function second_info_send($type, $order_info,$openid,$sellid)
    {

        $usage=new Usage();
        $openid_article=$usage->authcode($openid,'ENCODE',0);
        $url='http://'.$_SERVER['SERVER_NAME'].'/secondarticle/'.$sellid.'/'.$openid_article.'/';
//        $sendid=[];

        $rows = DB::table('se_info_detail')
            ->where('online', '1')
            ->where('is_all', '1')
            ->orderBy('id', 'desc')
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
        }

        switch ($type) {
            case 'ticket':
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
//                            $news->url = $row->article_url;
                            $news->url=$url.$row->id;
                            $news->image = $row->pic_url;
                            $content[] = $news;
                            $info_ids[]=$row->id;
                        }
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
//                            $news->url = $row->article_url;
                            $news->url=$url.$row->id;
                            $news->image = $row->pic_url;
                            $content[] = $news;
                            $info_ids[]=$row->id;
                        }
                    }
                    if ($row->hotel) {
                        if (strpos($order_info, $row->hotel) !== false) {
                            $news = new News();
                            $news->title = $row->title;
                            $news->description = $row->description;
//                            $news->url = $row->article_url;
                            $news->url=$url.$row->id;
                            $news->image = $row->pic_url;
                            $content[] = $news;
                            $info_ids[]=$row->id;
                        }
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
                    if ($row->hotel) {
                        if (strpos($order_info, $row->hotel) !== false) {
                            $news = new News();
                            $news->title = $row->title;
                            $news->description = $row->description;
//                            $news->url = $row->article_url;
                            $news->url=$url.$row->id;
                            $news->image = $row->pic_url;
                            $content[] = $news;
                            $info_ids[]=$row->id;
                        }
                    }
                break;
        }

        foreach ($info_ids as $info_id)
        {
            DB::table('se_info_send')
                ->insert(['wx_openid'=>$openid,'sellid'=>$sellid,'info_id'=>$info_id]);
        }

        return $content;

    }

}