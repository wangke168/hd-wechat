<?php
/**
 * Created by PhpStorm.
 * User: 吃不胖的猪
 * Date: 2016/8/24
 * Time: 9:49
 */

namespace App\WeChat;

use DB;

class Tour
{
    /**
     * 预约核销
     * @param $openid ：微信号
     * @param $project_id ：项目ID
     * @return string
     */
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

    /*
     * 获取相关项目的排队数据
     * int $project_id  项目id
     * int $type        1.查看每天可取号人数； 2.查看每小时可取号人数；3.取号类型（按天还是按小时）
     *
     * return int  返回对应的数字
     */
    public function get_wait_info($project_id, $type)
    {
        $row = DB::table('tour_project_wait')
            ->where('project_id', $project_id)
            ->first();
        switch ($type) {
            case "1":
                return $row->wait_all_amount;
                break;
            case "2":
                return $row->wait_amount;
                break;
            case "3":
                return $row->wait_type;
                break;
            default:
                return "无此类型数据";
                break;
        }
    }

    /**
     * 检查是否到预约时间
     * 早上8点半到下午15点
     * @return bool
     */
    public function  check_get_time($start_time, $end_time)
    {
        $starttime = strtotime($start_time);
        $endtime = strtotime($end_time);

        if (strtotime("now") < $starttime || strtotime("now") > $endtime) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * 检查5分钟内有多少人已经预约
     * @param $project_id
     * @return bool
     */

    public function check_queue($project_id, $numbers, $minute)
    {
        $nowMinute = date('i');
        $b = $nowMinute % $minute;
        $d = $nowMinute - $b + $minute;
        $c = $nowMinute - $b;
        $startTime = date('Y-m-d H-' . $c);
        $endTime = date('Y-m-d H-' . $d);

        $rowCount = DB::table('tour_project_wait_detail')
            ->where('project_id', $project_id)
            ->where('addtime', '>=', $startTime)
            ->where('addtime', '<', $endTime)
            ->count();
        if ($rowCount < $numbers) {
            $flag = true;
        } else {
            $flag = false;
        }
        return $flag;
    }

    public function insert_queue($project_id)
    {

    }


    /*
     * 检查该小时取号数是否已满
     *
     * int $project_id  取号项目
     *
     * int $type 1.查看每天号是否取满； 2.查看每小时号是否取满
     *
     * return flag 如果取号已满，则返回true,如果取号未满，则返回false
     *
     */
    public function check_amount($project_id, $type)
    {
//        $db = new DB();

        switch ($type) {
            case "1";
                /*                $row = $db->query("SELECT count(*)  as tempcount from tour_project_wait_detail where date(addtime)=:addtime",
                                    array("addtime" => date('Y-m-d')));*/
                $row = DB::table('tour_project_wait_detail')
                    ->whereDate('addtime', '=', date('Y-m-d'))
                    ->count();
                break;
            case "2":
                /*           $row = $db->query("SELECT count(*)  as tempcount from tour_project_wait_detail where date(addtime)=:addtime and hour(addtime)=:hourtime",
                               array("addtime" => date('Y-m-d'), "hourtime" => date('G')));*/
                $row = DB::table('tour_project_wait_detail')
                    ->whereDate('addtime', '=', date('Y-m-d'))
                    ->whereRaw('HOUR(addtime)=' . date("G"))
                    ->count();
                break;
            default:
                $row = "错误类型";
                break;
        }
//    return $row;
        $project_amount = $this->get_wait_info($project_id, $type);

        if ($row >= $project_amount) {
            return true; //如果该小时取号数大于设定值，则返回true
        } else {
            return false;
        }
    }

    /*
   * 检查当天该微信号是否已经取号
   *
   * int $type  1.检查当天是否取号； 2.检查该小时是否取号
   *
   * return flag 如果用户没有取号，则返回false,如果已经取号，则返回true
   *
   */

    public function check_wxid($openid, $type)
    {
        switch ($type) {
            case "1":
                /*                $row = $db->query("select count(*) as tempcount from tour_project_wait_detail where wx_openid=:wx_openid and   date(addtime)=:addtime",
                                    array("wx_openid" => $fromUsername, "addtime" => date('Y-m-d')));*/
                $row = DB::table('tour_project_wait_detail')
                    ->where('wx_openid', $openid)
                    ->whereDate('addtime', '=', date('Y-m-d'))
                    ->count();

                break;
            case "2":
                /*           $row = $db->query("select count(*) as tempcount from tour_project_wait_detail where wx_openid=:wx_openid AND  date(addtime)=:addtime and hour(addtime)=:hourtime",
                               array("wx_openid" => $fromUsername, "addtime" => date('Y-m-d'), "hourtime" => date('G')));*/
                $row = DB::table('tour_project_wait_detail')
                    ->where('wx_openid', $openid)
                    ->whereDate('addtime', '=', date('Y-m-d'))
                    ->whereRaw('HOUR(addtime)=' . date("G"))
                    ->count();
                break;
            default:
                $row = "该类型不存在";
                break;
        }

        if ($row == 0) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * 插入排队资料
     * @param $openid ：openid
     * @param $project_id
     * @return string
     */

    public function insert_wait_info($openid, $project_id)
    {


        $row_day = DB::table('tour_project_wait_detail')
            ->where('project_id', $project_id)
            ->whereDate('addtime', '=', date('Y-m-d'))
            ->orderBy('id', 'desc')
            ->first();

        $row_hour = DB::table('tour_project_wait_detail')
            ->whereDate('addtime', '=', date('Y-m-d'))
            ->whereRaw('HOUR(addtime)=' . date("G"))
            ->count();

        if (!$row_day) {
            $user_id = "1";
            $hour_id = '1';
        } else {
            $user_id = ($row_day->user_id) + 1;

            if ($row_hour == 0) {
                $hour_id = '1';
            } else {
                $hour_id = $row_hour + 1;
            }

        }

        $verification_time = $this->get_verification_time($hour_id,8,5);


        DB::table('tour_project_wait_detail')
            ->insert(['user_id' => $user_id, 'project_id' => $project_id, 'hour_id'=>$hour_id,'verification_time' => $verification_time, 'wx_openid' => $openid]);

        return "您的游玩时间段为" . $verification_time . "---16：30。";
    }


    private function get_verification_time($hour_id,$numbers,$minute)
    {
        $y = $hour_id % $numbers;
        $x = floor($hour_id / $numbers);
        $h = date('G') + 1;
        $m = date('i');

        if ($hour_id < 96) {
            if ($y == 0) {
                $t = (($x * $minute) - $minute);

            } else {
                $t = ($x * $minute);
            }
            if ($m > $t) {
                $t = $m;
            }
            $verification_time = date('Y-m-d ' . $h . ':' . $t);
        } else {
            $verification_time = date('Y-m-d '.($h+1).':00');
        }
        return $verification_time;
    }


    /**
     *获取该项目的地理位置
     *
     * int $project_id  项目id
     *
     * return string    项目在腾讯地图的位置
     */
    public function get_project_location($project_id)
    {
//        $row = $db->query("select project_location from tour_project_location where project_id=:project_id", array("project_id" => $project_id));
        $row = DB::table('tour_project_location')
            ->where('project_id', $project_id)
            ->first();
        if ($row) {
            return $row->project_location;
        } else {
            return "没有该项目id";
        }
    }


    /**
     * 获取演艺秀名字
     * @param $classid
     * @return string
     */
    public function get_project_name($classid)
    {
        $row = DB::table('tour_project_class')
            ->where('id', $classid)
            ->first();

        if ($row) {
            return $row->project_name;
        } else {
            return "该演艺秀不存在";
        }
    }

    /**
     *
     * 获取景区名称
     * int $classid  ID
     * int $type     type=1:景区id  type=2:演艺秀id
     * return 景区名称
     *
     */
    public function get_zone_name($classid, $type)
    {
        switch ($type) {
            case "1":
                $row = DB::table('tour_zone_class')
                    ->where('id', $classid)
                    ->first();
                if ($row) {
                    return $row->zone_name;
                } else {
                    return "该景区不存在";
                }
                break;
            case "2":
//                $row = $db->query("select zone_name from tour_zone_class where id=(select zone_classid from tour_project_class where id=:id)", array("id" => $classid));
                $row = DB::table('tour_zone_class')
                    ->whereRaw('id=(select zone_classid from tour_project_class where id=' . $classid . ')')
                    ->first();
                if ($row) {
                    return $row->zone_name;
                } else {
                    return "该景区不存在";
                }
                break;
            default:
                return "错误类型";
                break;
        }
    }

    public function subscribe($openid, $project_id)
    {
        $usage=new Usage();
        $openid = $usage->authcode($openid, 'DECODE', 0);
        $type = $this->get_wait_info('1', "3");
        if ($this->check_get_time('8:30', '15:00')) {
            if ($this->check_amount($project_id, $type)) //确定当天或当小时预约是否已满
            {
                if ($type == 1) {
                    $str = "<font color='red'>今天预约已满</font>";
                } elseif ($type == 2) {
                    $str = "<font color='red'>该小时预约已满</font>";
                }
            } else {
                if ($this->check_wxid($openid, "1")) //确定该微信号是否当下已经预约
                {
                    $str = "<font color='red'>不能重复取号</font>";
                } else {
                    $str = $this->insert_wait_info($openid, $project_id);
                    $project_loction = $this->get_project_location($project_id);
                    //        $project = new tour();
                    $project_name = $this->get_project_name($project_id);
                    $zone_name = $this->get_zone_name($project_id, "2");
                    $str1 = "您已经成功预约" . $zone_name . "景区" . $project_name . "项目，\n" . $str . "。\n如果您不清楚具体演出地点，<a href='" . $project_loction . "'>点我</a>";

                    $str = "<font color='green'>预约成功<br>" . $str . "</font>";

                    $app=app('wechat');
                    $app->staff->message($str1)->by('1001@u_hengdian')->to($openid)->send();
//                    $response = new responseMsg();
//                    $response->responseV_Text($openid, $str1);
                }
            }
        } else {
            $str = "<font color='red'>您好，现在无法预约，\n预约时间是8：30---15：00。</font>";
        }
        return $str;
    }


}