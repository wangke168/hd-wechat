<?php
/**
 * Created by PhpStorm.
 * User: 吃不胖的猪
 * Date: 2016/8/24
 * Time: 9:49
 */

namespace App\WeChat;

use DB;

class tour
{

    public function  verification_subscribe($openid, $project_id)
    {
        $row = DB::table('tour_project_wait_detail')
            ->where('wx_openid', $openid)
            ->where('project_id', $project_id)
            ->whereDate('addtime', '=', date('Y-m-d'))
            ->first();

        if (!$row) {
            $content = "您今天没有预约。";
        } elseif ($row->used == "1") {
            $content = "不能重复游玩。";
        } else {
            /*查询是否符合核销条件（当天，一小时前）*/
            $row1 = DB::table('tour_project_wait_detail')
                ->where('wx_openid', $openid)
                ->where('project_id', $project_id)
                ->whereDate('addtime', '=', date('Y-m-d'))
                ->where('addtime', '<=', date("Y-m-d H:i", time() - 3300))
                ->first();

            if (!$row1) {
                $content = "您好，现在未到您的预约时间";
            } else {

                $row2 = DB::table('tour_project_wait_detail')
                    ->where('wx_openid', $openid)
                    ->where('project_id', $project_id)
                    ->whereDate('addtime', '=', date('Y-m-d'))
                    ->update(['used' => '1', 'usetime' => date('Y-m-d H-i-s')]);


                if ($row2 > 0) {
                    $content = "您好，您现在可以入场。";
                } else {
                    $content = "核销有误，请联系工作人员。";
                }
            }
        }
        return $content;
    }
}