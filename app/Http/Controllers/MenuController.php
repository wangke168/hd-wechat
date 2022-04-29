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
                        "type" => "view",
                        "name" => "门票预定",
                        "url" => "https://wechat.hdyuanmingxinyuan.com/jump?id=1520"
                    ],
                    [
                        "type" => "view",
                        "name" => "门票+住宿预定",
                        "url" => "https://wechat.hdyuanmingxinyuan.com/jump?id=1521"
                    ],
                    [
                        "type" => "view",
                        "name" => "酒店预定",
                        "url" => "https://wechat.hdyuanmingxinyuan.com/jump?id=1522"
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
                        "type" => "view",
                        "name" => "购年卡立减50",
                        "url" => "https://wechat.hdyuanmingxinyuan.com/jump?id=1525"
                    ],
                    [
                        "type" => "view",
                        "name" => "超值年卡/季卡",
                        "url" => "https://wechat.hdyuanmingxinyuan.com/jump?id=1537"
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
                "name" => "购票中心",
                "type" => "view",
                "url"=>"http://sanke.hengdianworld.com/sanke_yd_index.aspx"
               /* "sub_button" => [
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

                ],*/
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

    private function add_other_hotel($tagid)
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
                "name" => "购票中心",
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
                "name" => "酒店中心",
                "sub_button" => [
                    [
                        "type" => "view",
                        "name" => "酒店介绍",
                        "url" => "http://m.hengdianworld.com/info_jq.aspx"
                    ],
                    [
                        "type" => "miniprogram",
                        "name" => "餐饮特惠",
                        "url" => "http://m.hengdianworld.com/info_yyx.aspx",
                        "appid"=>"wxec43a205882c487f",
                        "pagepath"=>"/pages/mall/typeIndex?typeId=534a321e12754c9385d0c912a319982"
                    ],
                    [
                        "type" => "miniprogram",
                        "name" => "客房预定",
                        "url" => "http://wx3e632d57ac5dcc68.wx.gcihotel.net/wechat/?/=#/bookSearch",
                        "appid"=>"wx4ab38795d8f78b40",
                        "pagepath"=>"/pages/order/bookSearch"
                    ],
                    [
                        "type" => "miniprogram",
                        "name" => "特惠商城",
                        "url" => "https://wx3e632d57ac5dcc68.wx.gcihotel.net/mall2/?/=#/",
                        "appid"=>"wxec43a205882c487f",
                        "pagepath"=>"/pages/mall/index"
                    ],
                    [
                        "type" => "miniprogram",
                        "name" => "会员中心",
                        "url" => "http://wx3e632d57ac5dcc68.wx.gcihotel.net/wechat/?/#/memberCenter",
                        "appid"=>"wx4ab38795d8f78b40",
                        "pagepath"=>"/pages/member/memberCenter"
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
