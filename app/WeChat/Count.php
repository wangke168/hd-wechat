<?php
/**
 * Created by PhpStorm.
 * User: wangke
 * Date: 16/10/26
 * Time: 下午12:17
 */

namespace App\WeChat;

use DB;


class Count
{
    /*
     * 增加阅读数wx_article
     *
     */
    public function add_article_hits($id)
    {
        DB::table('wx_article')
            ->where('id',$id)
            ->increment('hits');
    }

    /*
     * 插入阅读信息 wx_article_hits
     * $id: 文章id
     * $openid
     */
    public function insert_hits($id,$openid)
    {
        DB::table('wx_article_hits')
            ->insert(['article_id'=>$id,'wx_openid'=>$openid]);

        echo 'aaa';
    }

    /*
     * 增加转发数 wx_article表中的resp增加
     *
     */
    public function add_article_resp($id)
    {
        DB::table('wx_article')
            ->where('id',$id)
            ->increment('resp');
    }

    /*
     * 插入转发信息 wx_article_res
     *
     */
    public function insert_resp($id,$openid)
    {
        DB::table('wx_article_res')
            ->insert(['article_id'=>$id,'wx_openid'=>$openid]);
    }

    /*
     * 增加转发好友数
     */
    public function add_article_respf($id)
    {
        DB::table('wx_article')
            ->where('id',$id)
            ->increment('resp_f');
    }

}