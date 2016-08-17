<?php
/**
 * Created by PhpStorm.
 * User: 吃不胖的猪
 * Date: 2016/8/17
 * Time: 10:25
 */
namespace App\WeChat;

use DB;
use EasyWeChat\Message\News;
use App\Models\WechatArticle;
class Response{

    public function news(){
        $articles=DB::table('wx_article')->where('title','like','门票%')->orderBy('id','desc')->skip(0)->take(1)->get();

        foreach ($articles as $article)
        {
            $news = new News([
                'title'       => $article->title,
                'description' => '...',
                'url'         => $article->url,
                'image'       => $article->picurl,
                // ...
            ]);
        }

        return [$news];

    }
}