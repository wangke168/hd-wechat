<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use App\WeChat\Zone;
use Cache;
use App\WeChat\Tour;
use App\WeChat\Usage;
use EasyWeChat\Foundation\Application;
use EasyWeChat\Message\Text;
use DB;
use App\Models\WechatArticle;
use Illuminate\Http\Request;
use App\Http\Requests;
use Carbon\Carbon;
use EasyWeChat\Message\News;
use App\WeChat\Response;
class TestController extends Controller
{
    public $app;
    public $js;
    public $usage;

    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->usage=new Usage();
        $this->js = $this->app->js;

    }


    public function tag(Request $request)
    {

        $response=new Response();
        $type=$request->input('type');
        $eventkey='1000';
        $openid = 'o5--l1DMR3h9WS2dm9wa1LES6CoE';
        switch ($type){
            case 'tag_list':
                return $this->app->user_tag->lists();
                break;
            case 'tag_add':
                return $this->app->user_tag->create('测试');
                break;
            case 'tag_modify':
                return $this->app->user_tag->update('100','啦啦操');
                break;
            case 'get':
                return $this->app->user_tag->usersOfTag('100', $nextOpenId = '');
                break;
            case 'get_openid':
                return $this->app->user_tag->userTags($openid);
                break;
            case 'add':
//                $response->make_user_tag($openid,$eventkey); //标签管理
                $response->make_user_tag($openid, $eventkey);

//                if ($this->usage->query_tag_id($eventkey)) { //获取eventkey对应的tag
//                    $this->app->user_tag->batchTagUsers([$openid], $this->usage->query_tag_id($eventkey)); //增加标签
//                }
//                return $this->app->user_tag->batchTagUsers([$openid], '100'); //增加标签
//                return $this->app->user_tag->batchTagUsers([$openid], '100');
                break;
            case 'del':
                $openIds = ['o5--l1Pl9YZWPj9n342XbdpJdG8w'];
                return $this->app->user_tag->batchUntagUsers([$openid], '100');
                break;
            default:
                return 'sadasd';
                break;
        }
    }


    public function request_focus()
    {
        $openid='o5--l1DMR3h9WS2dm9wa1LES6CoE';
        $eventkey='1000';
        if (!$eventkey or $eventkey == "") {
            $eventkey = "all";
        }
        $flag = false; //先设置flag，如果news，txt，voice都没有的话，检查flag值，还是false时，输出默认关注显示
        //检查该二维码下关注回复中是否有图文消息
        if ($this->check_eventkey_message($eventkey, "news", "1")) {
            $flag = true;
//            $this->request_news($openid, $eventkey, '1', '', '');
//            $this->app->staff->message($content_news)->by('1001@u_hengdian')->to($openid)->send();
        }
        var_dump($flag);
    }
    /**
     * 检查关注是否有对应二维码的消息回复（图文、语音、文字、图片）
     * @param $eventkey
     * @param $type ：   news:图文    txt:文字      voice:语音     image:图片
     * @param $focus :   1:关注    0：不关注
     * @return boolkey
     */
    private function check_eventkey_message($eventkey, $type, $focus)
    {
//        $db = new DB();
        $flag = false;
        switch ($type) {
            case "news":
                $row_news = WechatArticle::focusPublished($eventkey)->first();

                if ($row_news) {
                    $flag = true;
                }
                break;
            case "txt":
                $row_txt = WechatTxt::focusPublished($eventkey)->first();

                if ($row_txt) {
                    $flag = true;
                }
                break;
            case "voice":
                $row_voice = WechatVoice::focusPublished($eventkey)->first();

                if ($row_voice) {
                    $flag = true;
                }
                break;
            case "image":
                $row_images = WechatImage:: focusPublished($eventkey)->first();

                if ($row_images) {
                    $flag = true;
                }
                break;
            default:
                break;

        }
        return $flag;
    }



    public function test()
    {
        $row = WechatArticle::where('classid', '23')
            ->usagePublished('all')
            ->skip(0)->take(8)->get();
        $content = array();
        foreach ($row as $result) {
            $url = $result->url;
            $id = $result->id;
            /*如果只直接跳转链接页面时，判断是否已经带参数*/
            if ($url != '') {
                $url = "https://" . $_SERVER['HTTP_HOST'] . "/jump/{$id}/";

            } else {
                $url = "https://" . $_SERVER['HTTP_HOST'] . "/article/detail?id=" . $id . "&wxnumber=";

            }

            $pic_url = "https://wx-control.hdyuanmingxinyuan.com/" . $result->picurl;

            /*索引图检查结束*/
            $new = new News();
            $new->title = $result->title;
            $new->description = $result->description;
            $new->url = $url;
//                $new->image = "http://weix2.hengdianworld.com/" . $result->picurl;
            $new->image = $pic_url;
            $content[] = $new;
        }
        var_dump($content);
    }



    private function http_request_json($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    private function CheckCardBan($eventkey)
    {
        $row=DB::table('wx_card_ban')
            ->where('id',1)
            ->first();
        if ($eventkey=='')
        {
            return true;
        }
        else {
            $tmparray = explode($eventkey, $row->eventkey);
            if (count($tmparray) > 1) {
                return true;
            } else {
                return false;
            }
        }

    }

    public function cache(Request $request)
    {

        if (Cache::has('temp')) {
//            return Cache::get('temp');
        } else {
            Cache::put('temp', 'cachekey', 60);
        }
//        return Cache::get('temp');


        $row = WechatArticle::where('classid', '15')
            ->usagePublished('all')
            ->skip(0)->take(8)->get();

        if ($row) {
            $content = array();
            foreach ($row as $result) {
                $url = $result->url;
                $id = $result->id;
                /*如果只直接跳转链接页面时，判断是否已经带参数*/
                if ($url != '') {
                    /*链接跳转的数据统计*/
//                    $url = "http://wechat.hengdianworld.com/jump/{$id}/{$openid}";
                    // $url = "http://".$_SERVER['HTTP_HOST']."/jump/{$id}/{$openid}";

                    /*          if (!strstr($url, 'project_id')) {
                                  if (strstr($url, '?') != '') {
                                      $url = $url . "&comefrom=1&wxnumber={$wxnumber}&uid={$uid}&wpay=1";
                                  } else {
                                      $url = $url . "?comefrom=1&wxnumber={$wxnumber}&uid={$uid}&wpay=1";
                                  }

                              } else {
                                  $url=$url . "&wxnumber={$openid}";
          //                        return redirect($url . "&wxnumber={$openid}");
                              }
          */
                } else {
//                    $url = "http://weix2.hengdianworld.com/article/articledetail.php?id=" . $id . "&wxnumber=" . $wxnumber;
                    //   $url = "http://".$_SERVER['HTTP_HOST']."/article/detail?id=" . $id . "&wxnumber=" . $wxnumber;

                }

                /*检查索引图所在服务器并生成链接*/
                /*     if(starts_with($result->picurl, 'uploads'))
                     {
                         $pic_url='http://weix2.hengdianworld.com/'.$result->picurl;
                     }
                     else
                     {
                         $pic_url="http://weix2.hengdianworld.com" . $result->picurl;
                     }*/

                $pic_url = 'http://weix2.hengdianworld.com/' . $result->picurl;

                /*索引图检查结束*/
                $new = new News();
                $new->title = $result->title;
                $new->description = $result->description;
                $new->url = $url;
//                $new->image = "http://weix2.hengdianworld.com/" . $result->picurl;
                $new->image = $pic_url;
                $content[] = $new;
            }

        }

    }
}