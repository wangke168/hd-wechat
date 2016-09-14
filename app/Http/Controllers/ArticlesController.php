<?php

namespace App\Http\Controllers;

use App\Models\WechatTxt;
use App\Models\WechatVoice;
use App\WeChat\Response;
use App\WeChat\Usage;
use Carbon\Carbon;
use DB;
use App\Models\WechatArticle;
use Illuminate\Http\Request;
use EasyWeChat\Message\Text;

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

    public function show($id)
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

    public function info()
    {
        $eventkey="123";
       /* $row = DB::table('wx_article')

            ->where(function ($query) use ($eventkey) {
                $query->whereRaw('FIND_IN_SET("'.$eventkey.'", eventkey)')
                    ->orWhereRaw('FIND_IN_SET("all", eventkey)');
            })
                ->where('audit', '1')
                ->where('del', '0')
                ->where('online', '1')
                ->where('startdate', '<=', date('Y-m-d'))
                ->where('enddate', '>=', date('Y-m-d'))
                ->orderBy('eventkey', 'asc')
                ->orderBy('priority', 'asc')
                ->orderBy('id', 'desc')
            ->pluck('eventkey');*/

/*                $row = WechatArticle::focusPublished('123')
                    ->pluck('eventkey');*/
//        $row=WechatVoice::focusPublished('123')->get();
        $app=app('wechat');
        $material = $app->material;

        $result = $material->uploadImage(public_path()."/images/bg.jpg");  // 请使用绝对路径写法！除非你正确的理解了相对路径（好多人是没理解对的）！
        var_dump($result);

   /*     $resource = $material->lists('voice', 0, 10);

        return $resource;*/

    }

    public function info_back_2()
    {
        $tagId = '102';
        $app = app('wechat');
        $tag = $app->user_tag;
        $tags = $tag->lists();
//        $tag->create('测试号标签');
//        $openIds = ['opUv9v1jQ2jTF4AIxirvBg2jrr_c', 'opUv9v977Njll_YHpZYMymxI_aPE'];
//        return $tag->batchTagUsers($openIds, $tagId);
        $openids = $tag->usersOfTag($tagId, $nextOpenId = '')->data;

        $openIds = $openids['openid'];

        /*        $tag->batchUntagUsers($openIds, $tagId);

                $openIds = $tag->usersOfTag($tagId, $nextOpenId = '')->data;*/
        return $openIds;

    }

    public function queue()
    {

        $row_hour = DB::table('tour_project_wait_detail')
            ->whereDate('addtime', '=', date('Y-m-d'))
            ->whereRaw('HOUR(addtime)=' . date("G"))
            ->count();

        $hour_id = $row_hour;

//        $n = 33;
        $y = $hour_id % 8;
        $x = floor($hour_id / 8);
        $h = date('G') + 1;

        if ($hour_id < 96) {
            if ($y == 0) {
                $t = (($x * 5) - 5);
//                $startTime = date('Y-m-d '.$h.'-'.$t);

            } else {
                $t = ($x * 5);
            }
            $startTime = date('Y-m-d ' . $h . '-' . $t);
        } else {
            $startTime = date("Y-m-d H:i", time() + 3600);
        }

        DB::table('tour_project_wait_detail')
            ->where('id', '17103')
            ->update(['verification_time' => $startTime]);


        $tour = new Tour();
        return $tour->insert_wait_info('sdsadsa', 1);


//        $z = array($x, $y);
//       return $startTime;
//        return $flag;
    }

    public function info_back_1()
    {

        $app = app('wechat');
        $row = DB::table('wx_location_list')
            ->orderBy('id', 'desc')
            ->get();
        foreach ($row as $result) {
            $aaa = explode(',', $result->show_time);
            $prevtime = date('Y-m-d');
            foreach ($aaa as $bbb) {
//        if (strtotime($bbb)-(strtotime("now"))/60)
                $temptime = (strtotime($bbb) - strtotime("now")) / 60;
                if ($temptime < 30 && $temptime > 0) {
                    /*                    $row1 = $db->query("SELECT * from wx_user_info where eventkey=:eventkey  and scandate = :days and UNIX_TIMESTAMP(endtime)>=:endtime order by id desc",
                                            array("eventkey" => $result['eventkey'], "days" => date('Y-m-d'),"endtime"=>strtotime($prevtime)));*/

                    $row1 = DB::table('wx_user_info')
                        ->where('eventkey', $result->eventkey)
                        ->where('scandate', date('Y-m-d'))
                        ->whereRaw('UNIX_TIMESTAMP(endtime)>=' . strtotime($prevtime))
                        ->get();

                    foreach ($row1 as $send_openid) {
                        /*                        $response->responseV_Text($ccc["wx_openID"], "您好，" .$result["zone_id"]."景区". $result["show_name"]."的演出时间是".$bbb."。还没到剧场的话要抓紧了哦。\n如果您不知道剧场位置，<a href='".$result["location_url"]."'>点我</a>\n微信演出时间有时无法及时更新，以景区公示为准。");
                                                $response->responseV_News($ccc['wx_openID'], $result["show_name"], "2");*/
                        $content = new Text();
                        $content->content = "您好，" . $result->zone_id . "景区" . $result->show_name . "的演出时间是" . $bbb . "。还没到剧场的话要抓紧了哦。\n如果您不知道剧场位置，<a href='" . $result->location_url . "'>点我</a>\n微信演出时间有时无法及时更新，以景区公示为准。";
                        $app->staff->message($content)->by('1001@u_hengdian')->to($send_openid->wx_openid)->send();
                    }


                    /*检查景区eventkey下有没有其他二维码，例：龙帝惊临项目在秦王宫里，因此龙帝惊临和秦王宫的二维码是从属关系，扫龙帝惊临的二维码也能收到秦王宫的节目提醒*/
//                    $qrscene_id=$this->get_eventkey_info($result['eventkey']);
                    $Usage = new Usage();
                    $qrscene_id = $Usage->get_eventkey_son_info($result->eventkey);
                    if ($qrscene_id) {
                        foreach ($qrscene_id as $key => $eventkey) {

                            $row2 = DB::table('wx_user_info')
                                ->where('eventkey', $result->eventkey)
                                ->where('scandate', date('Y-m-d'))
                                ->whereRaw('UNIX_TIMESTAMP(endtime)>=' . strtotime($prevtime))
                                ->get();

                            foreach ($row2 as $send_openid) {
                                /*  $response->responseV_Text($ddd["wx_openID"], "您好，" .$result["zone_id"]."景区". $result["show_name"]."的演出时间是".$bbb."。还没到剧场的话要抓紧了哦。\n如果您不知道剧场位置，<a href='".$result["location_url"]."'>点我</a>\n微信演出时间有时无法及时更新，以景区公示为准。");
                                  $response->responseV_News($ddd['wx_openID'], $result["show_name"], "2");*/
                                $content = new Text();
                                $content->content = "您好，" . $result->zone_id . "景区" . $result->show_name . "的演出时间是" . $bbb . "。还没到剧场的话要抓紧了哦。\n如果您不知道剧场位置，<a href='" . $result->location_url . "'>点我</a>\n微信演出时间有时无法及时更新，以景区公示为准。";
                                $app->staff->message($content)->by('1001@u_hengdian')->to($send_openid->wx_openid)->send();
                            }
                        }
                    }

                }
                $prevtime = $bbb;
            }
        }
    }


}
