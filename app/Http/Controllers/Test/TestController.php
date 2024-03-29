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
    public $material;

    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->usage=new Usage();
        $this->js = $this->app->js;
        $this->material = $app->material;
    }


    public function material(Request $request)
    {
        $type=$request->input('type');
//        $upload=$request->input('')
        if ($type=="upload"){
            $result = $this->material->uploadImage("/home/vagrant/Code/hd-wechat/public/images/temp/wlblh.png");  // 请使用绝对路径写法！除非你正确的理解了相对路径（好多人是没理解对的）！
            var_dump($result);
        }
//        $lists = $this->material->lists($type, 0, 10);
//        return $lists;
    }




    public function broadcast()
    {
        $groupId='102';
//        $media_id= "QQE-CzQ2CBuTXOaRorptMGlotyAW58T4yI3XU10mS-s";
        $text="各位参加米友圈粉丝节的朋友，优惠门票现已开放预定，预定时需填写本人身份证，游玩凭身份证检票入园。若提示身份证号码不能预定，请及时致电13905893038联系解决。";
        $broadcast = $this->app->broadcast;
//        $broadcast->sendNews($media_id, $groupId);
        $broadcast->sendText($text, $groupId);
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

    /**
     * 生成带参二维码
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

}