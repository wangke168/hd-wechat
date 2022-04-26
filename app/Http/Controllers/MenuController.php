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

    public function menu(Request $request)
    {
        $type = $request->input('type');
        switch ($type) {
            case 'index':
                $menus = $this->menu->all();
                return $menus;
                break;
            case 'add':
                $this->add();
                break;
            case 'add_other':
                $tagid = $request->input('tagid');
                $this->add_other($tagid);
                break;
            case 'del':
                $menuId = $request->input('menuid');
                $this->menu->destroy($menuId);
                break;
            default:
                $menus = $this->menu->all();
                return $menus;
                break;
        }
    }


    public function index()
    {
        $menus = $this->menu->all();
        return $menus;
    }

    private function add()
    {
        $buttons = [
            [
                "name" => "畅游横店",
                "sub_button" => [
                    [
                        "type" => "view",
                        "name" => "游玩攻略",
                        "url" => "https://wechat.hdyuanmingxinyuan.com/jump?id=1511"
                    ],
                    [
                        "type" => "view",
                        "name" => "剧组动态",
                        "url" => "https://wechat.hdyuanmingxinyuan.com/jump?id=1512"
                    ],
                    [
                        "type" => "view",
                        "name" => "节目时间",
                        "url" => "https://wechat.hdyuanmingxinyuan.com/jump?id=1513"
                    ],
                    [
                        "type" => "view",
                        "name" => "交通攻略",
                        "url" => "https://wechat.hdyuanmingxinyuan.com/jump?id=1514"
                    ],
                    [
                        "type" => "view",
                        "name" => "常见问题",
                        "url" => "https://wechat.hdyuanmingxinyuan.com/jump?id=1515"
                    ],
                ],
            ],
            [
                "name" => "购票预定",
                "sub_button" => [
                    [
                        "type" => "click",
                        "name" => "门票预定",
                        "key" => "7"
                    ],
                    [
                        "type" => "click",
                        "name" => "门票+住宿预定",
                        "key" => "8"
                    ],
                    [
                        "type" => "click",
                        "name" => "酒店预定",
                        "key" => "9"
                    ],
                    [
                        "type" => "view",
                        "name" => "订单查询",
                        "url" => "https://wechat.hdyuanmingxinyuan.com/jump?id=1516"
                    ],
                    [
                        "type" => "click",
                        "name" => "专属客服",
                        "key" => "11"
                    ],

                ],
            ],
            [
                "name" => "最新活动",
                "sub_button" => [
                    [
                        "type" => "view",
                        "name" => "全城送福●免费抽奖",
                        "url" => "https://wechat.hdyuanmingxinyuan.com/jump?id=1517"
                    ],
                    [
                        "type" => "view",
                        "name" => "升级年卡",
                        "url" => "https://wechat.hdyuanmingxinyuan.com/jump?id=1518"
                    ],
                    [
                        "type" => "click",
                        "name" => "购年卡立减50",
                        "key" => "15"
                    ],
                    [
                        "type" => "click",
                        "name" => "超值年卡/季卡",
                        "key" => "16"
                    ],
                    [
                        "type" => "view",
                        "name" => "门票加购80元起",
                        "url" => "https://wechat.hdyuanmingxinyuan.com/jump?id=1519"
                    ],
                    /*      [
                              "type" => "click",
                              "name" => "行程推荐",
                              "key"  => "22"
                          ],
                          [
                              "type" => "view",
                              "name" => "常见问题",
                              "url"  => "http://ydpt.hdymxy.com/yd_search.aspx"
                          ],*/
                ],
            ],
        ];

        /*        $matchRule = [
                    "tag_id"             => "100",
                    "sex"                  => "",
                    "country"              => "",
                    "province"             => "",
                    "city"                 => "",
                    "client_platform_type" => ""
                ];*/

//        $this->menu->add($buttons, $matchRule);
        $this->menu->add($buttons);

    }


    private function add_other($tagid)
    {
        $buttons = [
            [
                "name" => "畅游横店",
                "sub_button" => [
                    [
                        "type" => "view",
                        "name" => "游玩攻略",
                        "url" => "https://mp.weixin.qq.com/s/uYGh32ht_Tz0XkIRbwJoug"
                    ],
                    [
                        "type" => "view",
                        "name" => "剧组动态",
                        "url" => "https://mp.weixin.qq.com/s/blcC9BMEDviELXFoonYxdg"
                    ],
                    [
                        "type" => "view",
                        "name" => "交通攻略",
                        "url" => "https://mp.weixin.qq.com/s/vyKJt8EtOa0lAbvHDFgjug"
                    ],
                    [
                        "type" => "view",
                        "name" => "常见问题",
                        "url" => "https://mp.weixin.qq.com/s/GljFzb8Ygib_Dq0DdEI7Tw"
                    ],
                    [
                        "type" => "view",
                        "name" => "成功案例",
                        "url" => "https://mp.weixin.qq.com/s/d48y9Gso3MuaZqcUZsC6Rw"
                    ],
                ],
            ],
            [
                "name" => "购票攻略",
                "sub_button" => [
                    [
                        "type" => "view",
                        "name" => "门票预定",
                        "url" => "https://mp.weixin.qq.com/s/8GWBO7eNtkk9AMl4TpM4sQ"
                    ],
                    [
                        "type" => "view",
                        "name" => "套餐预定",
                        "url" => "https://mp.weixin.qq.com/s/8GWBO7eNtkk9AMl4TpM4sQ"
                    ],
                    [
                        "type" => "view",
                        "name" => "酒店预定",
                        "url" => "https://mp.weixin.qq.com/s/AQKGow97mWlyZC2h41y4Og"
                    ],
                    [
                        "type" => "view",
                        "name" => "订单查询",
                        "url" => "https://mp.weixin.qq.com/s/PNxklfedA_iSHwIqFrkzyA"
                    ],

                ],
            ],
            [
                "name" => "梦外滩",
                "sub_button" => [
                    [
                        "type" => "view",
                        "name" => "储值卡",
                        "url" => "http://m.hengdianworld.com/info_jq.aspx"
                    ],
                    [
                        "type" => "view",
                        "name" => "二销系统",
                        "url" => "http://m.hengdianworld.com/info_yyx.aspx"
                    ],
                    [
                        "type" => "view",
                        "name" => "尊享卡",
                        "url" => "https://mp.weixin.qq.com/s/kpUcrdVdAfOdsnZE_bJBSA"
                    ],
                    [
                        "type" => "view",
                        "name" => "横店疗休养",
                        "url" => "https://mp.weixin.qq.com/s/UOVSMJNaVxTBrDt984vHPw"
                    ],
                    /*      [
                              "type" => "click",
                              "name" => "行程推荐",
                              "key"  => "22"
                          ],
                          [
                              "type" => "view",
                              "name" => "常见问题",
                              "url"  => "http://ydpt.hdymxy.com/yd_search.aspx"
                          ],*/
                ],
            ],

            /*     [
                     "type" => "view",
                     "name" => "门票预订",
                     "url"  => "https://job.hdymxy.com/meeting/myq"
                 ],*/


        ];

        $matchRule = [
            "tag_id" => $tagid,
            "sex" => "",
            "country" => "",
            "province" => "",
            "city" => "",
            "client_platform_type" => ""
        ];

        $this->menu->add($buttons, $matchRule);
//        $this->menu->add($buttons);

    }


    public function add_temp()
    {
        $buttons = [
            [
                "name" => "景区资讯",
                "sub_button" => [
                    [
                        "type" => "click",
                        "name" => "最新活动",
                        "key" => "2"
                    ],
                    [
                        "type" => "click",
                        "name" => "景区简介",
                        "key" => "3"
                    ],
                    [
                        "type" => "click",
                        "name" => "演艺秀",
                        "key" => "4"
                    ],
                ],
            ],
            [
                "name" => "我要预订",
                "sub_button" => [
                    [
                        "type" => "click",
                        "name" => "门票预订",
                        "key" => "7"
                    ],
                    [
                        "type" => "view",
                        "name" => "订单查询",
                        "url" => "http://ydpt.hdyuanmingxinyuan.com/yd_search.aspx"
                    ],
                ],
            ],
            [
                "name" => "游玩攻略",
                "sub_button" => [
                    [
                        "type" => "click",
                        "name" => "客服电话",
                        "key" => "13"
                    ],
                    [
                        "type" => "click",
                        "name" => "节目时间表",
                        "key" => "14"
                    ],
                    [
                        "type" => "click",
                        "name" => "交通速查",
                        "key" => "16"
                    ],
                    [
                        "type" => "click",
                        "name" => "行程推荐",
                        "key" => "22"
                    ],
                    [
                        "type" => "view",
                        "name" => "常见问题",
                        "url" => "http://ydpt.hdyuanmingxinyuan.com/yd_search.aspx"
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
