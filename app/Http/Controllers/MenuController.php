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
                "name"       => "活动专区",
                "sub_button" => [
                    [
                        "type" => "click",
                        "name" => "最新活动",
                        "key"  => "2"
                    ],
                    [
                        "type" => "click",
                        "name" => "横店攻略",
                        "key"  => "19"
                    ],
                ],
            ],
            [
                "name"       => "我要预订",
                "sub_button" => [
                    [
                        "type" => "click",
                        "name" => "门票预订",
                        "key"  => "7"
                    ],
                    [
                        "type" => "click",
                        "name" => "特惠(门票+住宿)",
                        "key"  => "8"
                    ],
                    [
                        "type" => "click",
                        "name" => "酒店预订",
                        "key"  => "9"
                    ],
                    [
                        "type" => "click",
                        "name" => "火车跟团",
                        "key"  => "20"
                    ],
                    [
                        "type" => "view",
                        "name" => "订单查询",
                        "key"  => "http://e.hengdianworld.com/yd_search.aspx"
                    ],
                ],
            ],
            [
                "name"       => "更多服务",
                "sub_button" => [
                    [
                        "type" => "click",
                        "name" => "客服电话",
                        "key"  => "13"
                    ],
                    [
                        "type" => "click",
                        "name" => "景区节目时间表",
                        "key"  => "14"
                    ],
                    [
                        "type" => "click",
                        "name" => "剧组拍摄动态",
                        "key"  => "15"
                    ],
                    [
                        "type" => "click",
                        "name" => "交通速查/叫出租/导航",
                        "key"  => "16"
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
