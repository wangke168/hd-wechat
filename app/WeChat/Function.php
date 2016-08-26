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
    /**
     * 从wx_user_info获取用户资料
     * @param $openid
     * @return mixed|static
     */
    public function get_openid_info($openid)
    {
        $row = DB::table('wx_user_info')
            ->where('wx_openid', $openid)
            ->first();
        return $row;
    }

    /**
     * 获取eventkey相关信息
     * @param $eventkey
     * @return mixed|static
     */
    public function get_eventkey_info($eventkey)
    {
        $row = DB::table('wx_qrscene_info')
            ->where('qrscene_id', $eventkey)
            ->first();
        return $row;
    }


    /**
     * 获取uid
     * @param $fromUsername
     * @return string
     */
    public function get_uid($openid)
    {
        $uid = $this->get_eventkey_info($this->get_openid_info($openid)->eventkey)->uid;
        $endtime = $this->get_openid_info($openid)->endtime;
        if (!$uid) {
            $differs_days = (strtotime("now") - strtotime($endtime)) / 86400;
            if ($differs_days <= 10 && $differs_days > 1) {
                $uid = "627A7778313233";
            }
        }
        return $uid;
    }


    /**
     * 查询eventkey对应的tag
     * @param $eventkey
     * @return null
     */
    public function query_tag_id($eventkey)
    {
        $row = DB::table('wx_user_tag')->where('eventkey', $eventkey)->first();

        if ($row) {
            return $row->tag_id;
        } else {
            return null;
        }
    }


    public function v($openid, $project_id)
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
            /*     $row1 = $db->query("select * from tour_project_wait_detail WHERE wx_openid=:wx_openid AND project_id=:project_id AND  used=:used AND date(addtime)=:tempdate  AND UNIX_TIMESTAMP(addtime)<=:endtime",
                     array("wx_openid" => $fromUsername, "project_id" => $project_id, "used" => "0", "tempdate" => date('Y-m-d'), "endtime" => strtotime(date("Y-m-d H:i", time() - 3300))));
          */
            $row1 = DB::table('tour_project_wait_detail')
                ->where('wx_openid', $openid)
                ->where('project_id', $project_id)
                ->whereDate('addtime', '=', date('Y-m-d'))
                ->where('addtime', '<=', date("Y-m-d H:i", time() - 3300))
                ->first();

            if (!$row1) {
                $content = "您好，现在未到您的预约时间";
            } else {
                /*                $row2 = $db->query("update tour_project_wait_detail set used=:used,usetime=:usetime WHERE wx_openid=:wx_openid AND project_id=:project_id AND date(addtime)=:tempdate  and  UNIX_TIMESTAMP(addtime)<=:endtime",
                                    array("used" => "1","usetime"=>date('Y-m-d H-i-s'), "wx_openid" => $fromUsername, "project_id" => $project_id, "tempdate" => date('Y-m-d'), "endtime" => strtotime(date("Y-m-d H:i", time() - 3300))));
                       */
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