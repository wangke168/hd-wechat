<?php
/**
 * Created by PhpStorm.
 * User: 吃不胖的猪
 * Date: 2016/8/23
 * Time: 16:28
 */
namespace App\WeChat;

use EasyWeChat\Foundation\Application;
use DB;
use EasyWeChat\Message\News;
use EasyWeChat\Message\Text;
use App\Models\WechatArticle;
use App\Http\Requests;


class usage
{
    public function get_openid_info($openid)
    {
        $row=DB::table('wx_user_info')
            ->where('wx_openid',$openid)
            ->first();
        return $row;
    }

    public function v()
    {
        return "aaa";
    }
}