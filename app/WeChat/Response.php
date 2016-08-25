<?php
/**
 * Created by PhpStorm.
 * User: 吃不胖的猪
 * Date: 2016/8/17
 * Time: 10:25
 */
namespace App\WeChat;

use EasyWeChat\Foundation\Application;
use DB;
use EasyWeChat\Message\News;
use EasyWeChat\Message\Text;
use App\Models\WechatArticle;
use App\Http\Requests;
use Crypt;

class Response
{

    /*        public $wechat;

            public function __construct(Application $wechat){
                $this->wechat=$wechat;
            }*/
    /*    protected $usage;
        public function __construct(usage $usage)
        {
            $this->usage=$usage;
        }*/
    public function news($message, $keyword)
    {

        $app = app('wechat');
        $userService = $app->user;
        $fromUsername = $userService->get($message->FromUserName)->openid;
        switch ($keyword) {
            case "a":
                $content = new Text();
                $content->content = $app->access_token->getToken();
                break;
            case 's':
                $content = new News();
                $content->title = "laravel-wechat";
                $content->description = "测试";
                $content->url = "http://blog.unclewang.me/zone/subscribe/ldjl/asdass/";
                $content->image = "http://www.hengdianworld.com/images/JQ/scenic_dy.png";
                $app->staff->message([$content])->to($fromUsername)->send();
                break;
            case 'd':
                $content = new Text();
                $usage = new usage();
                $info = $usage->get_openid_info('o2e-YuBgnbLLgJGMQykhSg_V3VRI');
                $content->content = $info->eventkey;
                break;
            case 'hx':
                $content = new Text();
                $tour = new tour();
                $content->content = $tour->verification_subscribe($fromUsername, '1');
                break;
            case '天气':
                $content = new Text();
                $content->content = $this->get_weather_info();
                break;
            default:
                $content = $this->request_keyword($fromUsername, $keyword);
                break;
        }
        return $content;
    }

    /**
     * 菜单回复
     * @param $openid
     * @param $menuID
     * @return array|Text
     */
    public function click_request($openid, $menuid)
    {
        $usage=new usage();
        $eventkey=$usage->get_openid_info($openid)->eventkey;
        $content=$this->request_news($openid, $eventkey, '2', '',$menuid);
//        $this->add_menu_click_hit($openid, $menuid); //增加点击数统计
        return $content;
    }

    /**
     * 关键字回复
     * @param $openid
     * @param $keyword
     * @return array|Text
     */
    private function request_keyword($openid, $keyword)
    {
        $wxnumber = Crypt::encrypt($openid);
        $usage = new usage();
        $uid = $usage->get_eventkey_info($usage->get_openid_info($openid)->eventkey)->uid;
        $row = DB::table('wx_article')
            ->where('keyword', 'like', '%' . $keyword . '%')
            ->where('audit', '1')
            ->where('del', '0')
            ->where('online', '1')
            ->orderBy('priority', 'asc')
            ->orderBy('id', 'desc')
            ->skip(0)->take(8)->get();
        if ($row) {
            $content = array();
            foreach ($row as $result) {
                $url = $result->url;
                $id = $result->id;
                /*如果只直接跳转链接页面时，判断是否已经带参数*/
                if ($url != '') {
                    /*链接跳转的数据统计*/
                    $linkjump = "http://weix2.hengdianworld.com/inc/linkjump.php?id=" . $id;
                    if (strstr($url, '?') != '') {
                        $url = $url . "&wxnumber=" . $wxnumber . "&uid=" . $uid . "&wpay=1";
                    } else {
                        $url = $url . "?wxnumber=" . $wxnumber . "&uid=" . $uid . "&wpay=1";
                    }
                    $url = $linkjump . "&link=" . $url;
                } else {
                    $url = "http://weix2.hengdianworld.com/article/articledetail.php?id=" . $id . "&wxnumber=" . $wxnumber;
                }

                $new = new News();
                $new->title = $result->title;
                $new->description = $result->description;
                $new->url = $url;
                $new->image = "http://weix2.hengdianworld.com/" . $result->picurl;
                $content[] = $new;
            }
        } else {
            $content = new Text();
            $content->content = "嘟......您的留言已经进入自动留声机，小横横回来后会努力回复你的~\n您也可以拨打400-9999141立刻接通小横横。";
        }

        return $content;
    }

    /**
     * 关注回复
     * @param $fromUsername
     * @param $eventkey
     */
    public function request_focus($openid, $eventkey)
    {
        $wxnumber = Crypt::encrypt($openid);               //wxnumber加密
        $usage = new usage();
        if (!$eventkey or $eventkey == "") {
            $eventkey = "all";
        }
        $uid = $usage->get_eventkey_info($usage->get_openid_info($openid)->eventkey)->uid;

        $flag = false;    //先设置flag，如果news，txt，voice都没有的话，检查flag值，还是false时，输出默认关注显示
        //检查该二维码下关注回复中是否有图文消息
        if ($this->check_eventkey_message($eventkey, "news", "1")) {
            $flag = true;
            $content = request_news($openid, $eventkey, '1', '', '');
        }
        if ($this->check_eventkey_message($eventkey, "voice", "1")) {
            $flag = true;
            $this->responseV_Voice($openid, $eventkey, "1", "");
        }
        if ($this->check_eventkey_message($eventkey, "txt", "1")) {
            $flag = true;
            $this->request_focus_txt($openid, $eventkey);
        }

        if (!$flag)     //如果该二维码没有对应的关注推送信息
        {
            $content = request_news($openid, '', '1', '', '');
        }
        return $content;

        /*        //黄金周专属
                if (($eventkey == "87") || ($eventkey == "88") || ($eventkey == "90") || ($eventkey == "91")) {
                    $row = $db->query("SELECT * from wx_article where id='170'");
                } else {
                    if ($this->Query_Market_Article($eventkey, 1)) {
                        $row = $db->query("SELECT * from wx_article where msgtype=:msgtype and focus =:focus  and audit=:audit and online=:online and eventkey=:eventkey  and startdate<=:startdate and enddate>=:enddate  order by priority asc,id desc  LIMIT 0,10", array("msgtype" => "news", "focus" => "1", "audit" => "1", "online" => "1", "eventkey" => $eventkey, "startdate" => date('Y-m-d'), "enddate" => date('Y-m-d')));
                    } else {
                        $row = $db->query("SELECT * from wx_article where msgtype=:msgtype and focus =:focus  and audit=:audit and online=:online and eventkey=:eventkey  and startdate<=:startdate and enddate>=:enddate  order by priority asc,id desc  LIMIT 0,10", array("msgtype" => "news", "focus" => "1", "audit" => "1", "online" => "1", "eventkey" => "all", "startdate" => date('Y-m-d'), "enddate" => date('Y-m-d')));
                    }
                }*/


    }

    /**
     * 检查关注是否有对应二维码的消息回复（图文、语音、文字、图片）
     * @param $eventkey
     * @param $type ：   news:图文    txt:文字      voice:语音
     * @param $focus :   1:关注    0：不关注
     * @return boolkey
     */
    private function  check_eventkey_message($eventkey, $type, $focus)
    {
//        $db = new DB();
        $flag = false;
        switch ($type) {
            case "news":
                $row_news = DB::table('wx_article')
                    ->where('msgtype', 'news')
                    ->where('focus', $focus)
                    ->where('audit', '1')
                    ->where('del', '0')
                    ->where('online', '1')
                    ->where('eventkey', $eventkey)
                    ->whereDate('startdate', '<=', date('Y-m-d'))
                    ->whereDate('enddate', '>=', date('Y-m-d'))
                    ->first();

                if ($row_news) {
                    $flag = true;
                }
                break;
            case "txt":
                /*            $row_txt = $db->query("select id from wx_txt_request where eventkey=:eventkey AND online=:online AND focus=:focus order BY id desc limit 0,1",
                                array("eventkey" => $eventkey, "online" => "1", "focus" => $focus));*/

                $row_txt = DB::table('wx_txt_request')
                    ->where('eventkey', $eventkey)
                    ->where('online', '1')
                    ->where('focus', $focus)
                    ->first();

                if ($row_txt) {
                    $flag = true;
                }
                break;
            case "voice":
                /*              $row_voice = $db->query("select id from wx_voice_request where eventkey=:eventkey AND online=:online AND focus=:focus order BY id desc limit 0,1",
                                  array("eventkey" => $eventkey, "online" => "1", "focus" => $focus));*/
                $row_voice = DB::table('wx_voice_request')
                    ->where('eventkey', $eventkey)
                    ->where('online', '1')
                    ->where('focus', $focus)
                    ->first();

                if ($row_voice) {
                    $flag = true;
                }
                break;
            default:
                break;

        }
        return $flag;
    }


    /**
     * 推送图文
     * @param $openid
     * @param $eventkey
     * @param $type 1：关注    2：菜单    3：关键字
     * @param $keyword      关键字
     * @param $menuid       菜单ID
     */
    public function request_news($openid, $eventkey, $type, $keyword, $menuid)
    {
        $wxnumber = Crypt::encrypt($openid);
        $usage = new usage();
        $uid = $usage->get_eventkey_info($eventkey)->uid;
        if (!$eventkey) {
            $eventkey = 'all';
        }
        switch ($type) {
            case 1:
                $row = DB::table('wx_article')
                    ->where('msgtype', 'news')
                    ->where('focus', '1')
                    ->where('audit', '1')
                    ->where('del', '0')
                    ->where('online', '1')
                    ->where('eventkey', $eventkey)
                    ->whereDate('startdate', '<=', date('Y-m-d'))
                    ->whereDate('enddate', '>=', date('Y-m-d'))
                    ->orderBy('priority', 'asc')
                    ->orderBy('id', 'desc')
                    ->skip(0)->take(8)->get();
                break;
            case 2:
                $uid = $usage->get_uid($openid);
                $row = DB::table('wx_article')
                    ->where('msgtype', 'news')
                    ->where('classid', $menuid)
                    ->published()
                    ->orderBy('eventkey', 'asc')
                    ->orderBy('priority', 'asc')
                    ->orderBy('id', 'desc')
                    ->skip(0)->take(8)->get();
                break;
        }
        if ($row) {
            $content = array();
            foreach ($row as $result) {
                $url = $result->url;
                $id = $result->id;
                /*如果只直接跳转链接页面时，判断是否已经带参数*/
                if ($url != '') {
                    /*链接跳转的数据统计*/
                    $linkjump = "http://weix2.hengdianworld.com/inc/linkjump.php?id=" . $id;
                    if (strstr($url, '?') != '') {
                        $url = $url . "&wxnumber=" . $wxnumber . "&uid=" . $uid . "&wpay=1";
                    } else {
                        $url = $url . "?wxnumber=" . $wxnumber . "&uid=" . $uid . "&wpay=1";
                    }
                    $url = $linkjump . "&link=" . $url;
                } else {
                    $url = "http://weix2.hengdianworld.com/article/articledetail.php?id=" . $id . "&wxnumber=" . $wxnumber;
                }
                $new = new News();
                $new->title = $result->title;
                $new->description = $result->description;
                $new->url = $url;
                $new->image = "http://weix2.hengdianworld.com/" . $result->picurl;
                $content[] = $new;
            }
        } else {
            $content = new Text();
            $content->content = "嘟......您的留言已经进入自动留声机，小横横回来后会努力回复你的~\n您也可以拨打400-9999141立刻接通小横横。";
        }
        return $content;
    }


    /**
     * 增加菜单点击数
     * @param $openid
     * @param $menuID
     */

    private function add_menu_click_hit($openid, $menuID)
    {
        DB::table('wx_click_hits')
            ->insert(['wx_openid' => $openid, 'click' => $menuID]);
    }

    /**
     * 获取天气资讯
     * @return string
     */
    private function get_weather_info()
    {
        $json = file_get_contents("http://api.map.baidu.com/telematics/v3/weather?location=%E4%B8%9C%E9%98%B3&output=json&ak=2c87d6d0443ab161753291258ac8ab7a");
        $data = json_decode($json, true);
        $contentStr = "【横店天气预报】：\n\n";
        $contentStr = $contentStr . $data['results'][0]['weather_data'][0]['date'] . "\n";
        $contentStr = $contentStr . "天气情况：" . $data['results'][0]['weather_data'][0]['weather'] . "\n";
        $contentStr = $contentStr . "气温：" . $data['results'][0]['weather_data'][0]['temperature'] . "\n\n";
        $contentStr = $contentStr . "明天：" . $data['results'][0]['weather_data'][1]['date'] . "\n";
        $contentStr = $contentStr . "天气情况：" . $data['results'][0]['weather_data'][1]['weather'] . "\n";
        $contentStr = $contentStr . "气温：" . $data['results'][0]['weather_data'][1]['temperature'] . "\n\n";
        $contentStr = $contentStr . "后天：" . $data['results'][0]['weather_data'][2]['date'] . "\n";
        $contentStr = $contentStr . "天气情况：" . $data['results'][0]['weather_data'][2]['weather'] . "\n";
        $contentStr = $contentStr . "气温：" . $data['results'][0]['weather_data'][2]['temperature'] . "\n";
        return $contentStr;
    }

    public function scopePublished($query)
    {
        $query->where('audit', '1')
            ->where('del', '0')
            ->where('online', '1')
            ->where('startdate', '<=', date('Y-m-d'))
            ->where('enddate', '>=', date('Y-m-d'));
    }

}