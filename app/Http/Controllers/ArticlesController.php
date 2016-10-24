<?php

namespace App\Http\Controllers;

use App\Jobs\ConfrimOrderQueue;
use App\Jobs\UpdateEscQueue;
use App\Models\WechatImage;
use App\Models\WechatTxt;
use App\Models\WechatVoice;
use App\WeChat\Order;
use App\WeChat\Response;
use App\WeChat\Usage;
use Carbon\Carbon;
use DB;
use App\Models\WechatArticle;
use EasyWeChat\Message\Image;
use EasyWeChat\Message\News;
use Illuminate\Http\Request;
use EasyWeChat\Message\Text;

use App\WeChat\Tour;
use App\Http\Requests;

//use Illuminate\Support\Facades\Cache;

class ArticlesController extends Controller
{

    public function second_article($sellid,$info_id,$openid)
    {
        $usage = new Usage();
//        $openid = $usage->authcode($openid, 'DECODE', 0);

        //设置se_info_send阅读
        DB::table('se_info_send')
            ->where('sellid',$sellid)
            ->where('wx_openid',$openid)
            ->where('info_id',$info_id)
            ->update(['is_read'=>1,'readtime'=>Carbon::now()]);

        //找出对应url并跳转
        $row=DB::table('se_info_detail')
            ->where('id',$info_id)
            ->first();
        $url=$row->article_url;
        return redirect($url);
    }










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
        $eventkey = '145';
//        $eventkey_temp = array("145", "100000");
//        if (in_array($eventkey, $eventkey_temp)) {
        /*            $row = DB::table('wx_article')
                        ->where('remark', 'test')
                        ->whereDate('startdate', '<=', date('Y-m-d'))
                        ->whereDate('enddate', '>=', date('Y-m-d'))
                        ->orderBy('id', 'asc')
                        ->skip(0)->take(8)->get();*/
        $usage = new Usage();
        $eventkey = $usage->CheckEventkey($eventkey);
        $eventkey_temp = array("145", "100000");
        if (in_array($eventkey, $eventkey_temp)) {

            $row = WechatArticle::focusPublished_temp($eventkey)
                ->skip(0)->take(8)->get();
            if ($row) {
                $content = array();
                foreach ($row as $result) {
                    $url = $result->url;
                    $id = $result->id;
                    /*如果只直接跳转链接页面时，判断是否已经带参数*/
//                $url='';
                    if ($url != '') {
                        /*链接跳转的数据统计*/
//                    $url = "http://wechat.hengdianworld.com/jump/{$id}/{$openid}";
                    } else {
//                    $url = "http://weix2.hengdianworld.com/article/articledetail.php?id=" . $id . "&wxnumber=" . $wxnumber;
                    }
                    $new = new News();
                    $new->title = $result->title;
                    $new->description = $result->description;
                    $new->url = $url;
                    $new->image = "http://weix2.hengdianworld.com/" . $result->picurl;
                    $content[] = $new;

                }
                return $content;
                /*            $app=app('wechat');
                            $app->staff->message($content)->by('1001@u_hengdian')->to('opUv9v977Njll_YHpZYMymxI_aPE')->send();*/
            }
        }
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
