<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use EasyWeChat\Foundation\Application;

class MenuController extends Controller
{
    public $app;
    public $menu;

//    public $usage;

    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->menu = $app->menu;
//        $this->usage = new Usage();
    }

    public function index()
    {
        $menus = $this->menu->all();
        return $menus;
    }

    public function add()
    {
        $buttons = [
            [
                "name"       => "圆明新园",
                "sub_button" => [
                    [
                        "type" => "view",
                        "name" => "优惠购票",
                        "url"  => "http://e-test.hdyuanmingxinyuan.com/mobile/epay.aspx"
                    ],
                    [
                        "type" => "view",
                        "name" => "景区简介",
                        "url"  => "http://www.hdymxy.com/attraction.html"
                    ],
                    [
                        "type" => "view",
                        "name" => "地图导览",
                        "url"  => "http://nwx.weijingtong.com/share/96783471470812882316?url=/map?id=206"
                    ],
                    [
                        "type" => "view",
                        "name" => "语音导览",
                        "url"  => "http://nwx.weijingtong.com/share/85374461470812912720?url=/scenery?clientId=348"
                    ],
                ],
            ],
            [
                "name"       => "有趣有料",
                "sub_button" => [
                    [
                        "type" => "view",
                        "name" => "游玩看攻略",
                        "url"  => "http://nwx.weijingtong.com/share/14087801470812978302?url=/corpus?id=360"
                    ],
                    [
                        "type" => "view",
                        "name" => "活动新资讯",
                        "url"  => "http://nwx.weijingtong.com/corpus/361"
                    ],
                ],
            ],
            [
                "name"       => "游园指南",
                "sub_button" => [
                    [
                        "type" => "click",
                        "name" => "客服电话",
                        "key"  => "13"
                    ],
                    [
                        "type" => "view",
                        "name" => "百事通",
                        "url"  => "http://nwx.weijingtong.com/share/78026951470813508244?url=/corpus?id=358"
                    ],
                    [
                        "type" => "view",
                        "name" => "http://nwx.weijingtong.com/share/96640011470813520230?url=/corpus?id=359",
                        "url"  => "15"
                    ],
                    [
                        "type" => "view",
                        "name" => "天气预报",
                        "url"  => "http://nwx.weijingtong.com/share/54800031470813531244?url=/weather?clientId=348"
                    ],
                ],
            ],
        ];

      /*  $matchRule = [
            "tag_id"             => "173",
            "sex"                  => "",
            "country"              => "",
            "province"             => "",
            "city"                 => "",
            "client_platform_type" => ""
        ];*/

//        $this->menu->add($buttons, $matchRule);
        $this->menu->add($buttons);

    }
}
