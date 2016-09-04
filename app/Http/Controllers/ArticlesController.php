<?php

namespace App\Http\Controllers;

use App\WeChat\Response;
use Carbon\Carbon;
use DB;
use App\Models\WechatArticle;
use Illuminate\Http\Request;

use App\WeChat\Tour;
use App\Http\Requests;

class ArticlesController extends Controller
{

    public function index()
    {
//        $articles = Article::all();
        $articles = DB::table('wx_article')->where('title', 'like', '门票%')->orderBy('id', 'desc')->skip(0)->take(2)->get();
//        return $articles;
        return view('articles.index', compact('articles'));
    }

    public function  show($id)
    {
        $article = WechatArticle::find($id);
//        $aaa=WechatArticle::
//        return $article;
        return view('articles.show', compact('article'));
    }

    public function detail($id)
    {
        $article = WechatArticle::find($id);
        return view('articles.detail', compact('article'));
    }

    public function queue()
    {
        $nowTime=date('m');
        $startTime='2016-9-4 16:40';
        $endTime='2016-9-4 16:45';

        $tempTime=date('Y-m-d H-5');

//        return $tempTime;

//        Carbon::now('');
        $a=date('i');
        $b=$a%5;
        $d=$a-$b+5;
        $c=$a-$b;
        $startTime=date('Y-m-d H-'.$c);
        $endTime=date('Y-m-d H-'.$d);
        $e=array($a,$c,$d,$startTime,$endTime);
        return $e;



//        return $nowTime;
       /* $row=DB::table('tour_project_wait_detail')
            ->where('addtime','>=',$startTime)
            ->where('addtime','<',$endTime)
            ->count();
        return $row;*/
    }

    public function info()
    {
        $tour=new Tour();
        /*        $row = $db->query("select * from tour_project_wait_detail WHERE wx_openid=:wx_openid AND date(addtime)=:temptime",
                    array("wx_openid" => $fromUsername, "temptime" => date("Y-m-d")));*/
        $result = DB::table('tour_project_wait_detail')
            ->where('wx_openid', 'opUv9v977Njll_YHpZYMymxI_aPE')
            ->whereDate('addtime', '=', date('Y-m-d'))
            ->first();
        if (!$result) {
//            $responseMsg->responseV_Text($fromUsername, "您好，您今天没有预约。");
            $content = "您好，您今天没有预约。";
        } else {
//            foreach ($row as $result) {
                $project_id = $result->project_id;

                $project_name = $tour->get_project_name($project_id);
                $zone_name = $tour->get_zone_name($project_id, "2");
                $datetime = date($result->addtime);
                $starttime = date("H:i", strtotime($result->addtime) + 3600);
//                $endtime = date("H:i", strtotime($result->addtime) + 7200);
                if ($result->used == 0) {
                    $used = "未使用";
                } else {
                    $used = "已使用";
                }
                $str = "您预约了" . $datetime . $zone_name . "景区" . $project_name . "项目;\n预约时间：" . $starttime . "---16：30.状态：" . $used;
//                $responseMsg->responseV_Text($fromUsername, $str);
                $content = $str;
            }
//        }
        return $content;
    }


}
