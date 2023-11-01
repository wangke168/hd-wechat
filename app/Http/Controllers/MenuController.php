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
                        "name" => "景区地图",
                        "url" => "https://www.jihex.com/html/v2/customerPage/index/99324?dt=52882390"
//                        "url" => "https://hdwechat.hengdianworld.com/jump?id=1591"

                    ],
                    [
                        "type" => "view",
                        "name" => "景区介绍",
                        "url" => "https://www.hengdianworld.com/mobile/theme.html"
//                        "url" => "https://hdwechat.hengdianworld.com/jump?id=1591"

                    ],
                    [
                        "type" => "view",
                        "name" => "剧组动态",
                        "url" => "https://www.hengdianworld.com/mobile/detail.html?id=2804"
//                        "url" => "https://hdwechat.hengdianworld.com/jump?id=1512"
                    ],
                    [
                        "type" => "view",
                        "name" => "节目时间",
                        "url" => "https://www.hengdianworld.com/mobile/time.html"
//                        "url" => "https://hdwechat.hengdianworld.com/jump?id=1513"
                    ],
                    [
                        "type" => "view",
                        "name" => "交通攻略",
                        "url" => "https://www.hengdianworld.com/mobile/traffic.html"
//                        "url" => "https://hdwechat.hengdianworld.com/jump?id=1514"
                    ],
                   /* [
                        "type" => "view",
                        "name" => "常见问题",
                        "url" => "https://hdwechat.hengdianworld.com/jump?id=1513"
//                        "url" => "https://hdwechat.hengdianworld.com/jump?id=1515"
                    ],*/
                ],
            ],
            [
                "name" => "立即预订",
                "sub_button" => [
            /*        [
                        "type" => "view",
                        "name" => "五一特惠预售",
                        "url" => "https://hdwechat.hengdianworld.com/jump?id=1587"
                    ],*/
                    [
                        "type" => "view",
                        "name" => "门票预定",
                        "url" => "http://e.hengdianworld.com/mobile/epay.aspx"
//                        "url" => "https://hdwechat.hengdianworld.com/jump?id=1520"
                    ],
                    [
                        "type" => "view",
                        "name" => "酒店服务",
//                        "url" => "https://hdwechat.hengdianworld.com/jump?id=1593"
                        "type" => "miniprogram",
                        "url" => "http://m.hengdianworld.com/",
                        "appid" => "wxd2e8a996a486b48b",
                        "pagepath" => "/pages/customPage/customPage?pageId=46365&dt=52882390"
                    ],
                    [
                        "type" => "view",
                        "name" => "门票+住宿预定",
                        "url" => "http://e.hengdianworld.com/yd_tc.aspx"
//                        "url" => "https://hdwechat.hengdianworld.com/jump?id=1521"
                    ],
                    [
                        "type" => "view",
                        "name" => "横店年卡",
                        "url" => "https://e.hengdianworld.com/yd_mp_activity.aspx?id=141"
//                        "url" => "https://hdwechat.hengdianworld.com/jump?id=1537"
                    ],
                    [
                        "type" => "view",
                        "name" => "剧组拍摄地",
                        "url" => "https://e.hengdianworld.com/yd_mp_activity.aspx?id=186"
//                        "url" => "https://hdwechat.hengdianworld.com/jump?id=1557"
                    ],

                ],
            ],
            [
                "name" => "个人服务",
                "sub_button" => [
                    /*[
                        "type" => "view",
                        "name" => "全城送福●免费抽奖",
                        "url" => "http://mh.zjqsa.com/zp/index.aspx"
                    ],*/
                    [
                        "type" => "view",
                        "name" => "订单查询",
                        "url" => "http://e.hengdianworld.com/yd_search.aspx"
//                        "url" => "https://hdwechat.hengdianworld.com/jump?id=1516"
                    ],
                    [
                        "type" => "view",
                        "name" => "客服咨询",
                        "url" => "https://hdyscwl.qiyukf.com/client?k=762336eee6f3d299d818075a902ebc61&wp=1&robotShuntSwitch=1&robotId=90662"
//                        "url" => "https://hdwechat.hengdianworld.com/jump?id=1531"
                    ],
                    /*[
                        "type" => "view",
                        "name" => "29元荧光跑",
                        "url" => "https://hdwechat.hengdianworld.com/jump?id=1554"
                    ],*/
                    [
                        "type" => "view",
                        "name" => "我的优惠券",
                        "url" => "https://e.hengdianworld.com/unionCard/unionCard_search.aspx"
//                        "url" => "https://hdwechat.hengdianworld.com/jump?id=1589"
                    ],
                    /*         [
                                 "type" => "view",
                                 "name" => "购年卡立减50",
                                 "url" => "https://e.hengdianworld.com/yd_mp_activity.aspx?id=816"
                             ],*/
                   /* [
                        "type" => "view",
                        "name" => "酒景加点",
                        "url" => "https://hdwechat.hengdianworld.com/jump?id=1559"
                    ],*/
                    [
                        "type" => "view",
                        "name" => "门票加购",
                        "url" => "https://www.jihex.com/html/v2/customerPage/index/74235?dt=52882390"
//                        "url" => "https://hdwechat.hengdianworld.com/jump?id=1519"
                    ],
                    [
                        "name" => "文旅卡会员中心",
                        "type" => "miniprogram",
                        "url" => "http://m.hengdianworld.com/",
                        "appid" => "wx6848f3c913fc16b5",
                        "pagepath" => "pages/mall/index"
                    ],
                    /*[
                        "type" => "view",
                        "name" => "官方分销",
                        "url" => "https://hdwechat.hengdianworld.com/jump?id=1564"
                    ],*/
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

    private function add_back()
    {
        $buttons = [
            [
                "name" => "畅游横店",
                "sub_button" => [
                    [
                        "type" => "view",
                        "name" => "游玩攻略",
                        "url" => "https://hdwechat.hengdianworld.com/jump?id=1511"
                    ],
                    [
                        "type" => "view",
                        "name" => "剧组动态",
                        "url" => "https://hdwechat.hengdianworld.com/jump?id=1512"
                    ],
                    [
                        "type" => "view",
                        "name" => "节目时间",
                        "url" => "https://hdwechat.hengdianworld.com/jump?id=1513"
                    ],
                    [
                        "type" => "view",
                        "name" => "交通攻略",
                        "url" => "https://hdwechat.hengdianworld.com/jump?id=1514"
                    ],
                    [
                        "type" => "view",
                        "name" => "常见问题",
                        "url" => "https://hdwechat.hengdianworld.com/jump?id=1515"
                    ],
                ],
            ],
            [
                "name" => "购票预定",
                "sub_button" => [
                    [
                        "type" => "view",
                        "name" => "门票预定",
                        "url" => "https://hdwechat.hengdianworld.com/jump?id=1520"
                    ],
                    [
                        "type" => "view",
                        "name" => "门票+住宿预定",
                        "url" => "https://hdwechat.hengdianworld.com/jump?id=1521"
                    ],
                    [
                        "type" => "view",
                        "name" => "酒店预定",
                        "url" => "https://hdwechat.hengdianworld.com/jump?id=1522"
                    ],
                    [
                        "type" => "view",
                        "name" => "订单查询",
                        "url" => "https://hdwechat.hengdianworld.com/jump?id=1516"
                    ],
                    [
                        "type" => "click",
                        "name" => "专属客服",
                        "key" => "11"
                    ],

                ],
            ],
            [
                "name" => "双11特惠",
                "sub_button" => [
                    /*[
                        "type" => "view",
                        "name" => "全城送福●免费抽奖",
                        "url" => "http://mh.zjqsa.com/zp/index.aspx"
                    ],*/
                    [
                        "type" => "view",
                        "name" => "影视拍摄地",
                        "url" => "https://hdwechat.hengdianworld.com/jump?id=1557"
                    ],
                    [
                        "type" => "view",
                        "name" => "双11特惠",
                        "url" => "https://hdwechat.hengdianworld.com/jump?id=1553"
                    ],
                    /*[
                        "type" => "view",
                        "name" => "29元荧光跑",
                        "url" => "https://hdwechat.hengdianworld.com/jump?id=1554"
                    ],*/
                    [
                        "type" => "view",
                        "name" => "升级年卡",
                        "url" => "https://hdwechat.hengdianworld.com/jump?id=1523"
                    ],
           /*         [
                        "type" => "view",
                        "name" => "购年卡立减50",
                        "url" => "https://e.hengdianworld.com/yd_mp_activity.aspx?id=816"
                    ],*/
                    [
                        "type" => "view",
                        "name" => "超值年卡/季卡",
                        "url" => "https://hdwechat.hengdianworld.com/jump?id=1537"
                    ],
                    [
                        "type" => "view",
                        "name" => "门票加购80元起",
                        "url" => "https://hdwechat.hengdianworld.com/jump?id=1519"
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


    /**
     * 个性化菜单（景区）
     * @param $tagid
     */
    private function add_other_jq($tagid)
    {
        $buttons = [
            [
                "name" => "畅游横店",
                "sub_button" => [
                    [
                        "type" => "view",
                        "name" => "官方网站",
                        "url" => "http://wx2.hengdianworld.com/jump?id=1541"
                    ],

                    [
                        "type" => "view",
                        "name" => "节目时间",
                        "url" => "http://wx2.hengdianworld.com/jump?id=1513"
                    ],

                    [
                        "type" => "view",
                        "name" => "剧组动态",
                        "url" => "http://wx2.hengdianworld.com/jump?id=1512"
                    ],
                    [
                        "type" => "view",
                        "name" => "游玩攻略",
                        "url" => "http://wx2.hengdianworld.com/jump?id=1511"
                    ],
                    [
                        "type" => "view",
                        "name" => "在线客服",
                        "url" => "http://wx2.hengdianworld.com/jump?id=1540"
                    ],
                ],
            ],
            [
                "name" => "入园预约",
                "type" => "miniprogram",
                "url" => "http://m.hengdianworld.com/",
                "appid" => "wxb07d9741a63f038f",
                "pagepath" => "/packageA/pages/gym-detail/gym-detail?id=13990"
            ],
            [
                "name" => "购票中心",
                "type" => "miniprogram",
                "url" => "http://m.hengdianworld.com/",
                "appid" => "wxb07d9741a63f038f",
                "pagepath" => "/packageA/pages/activity-receive/activity-receive?activitySkinId=100"
            ],
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

    /**
     * 个性化菜单（窗口）
     * @param $tagid
     */
    private function add_other_chuan($tagid)
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
                "url" => "http://sanke.hengdianworld.com/sanke_yd_index.aspx"
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
                ],
            ],
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

    /**
     * 个性化菜单（酒店中心）
     * @param $tagid
     */
    private function add_other($tagid)
    {
        $buttons = [
            [
                "name" => "畅游横店",
                "sub_button" => [
                    [
                        "type" => "view",
                        "name" => "官方网站",
                        "url" => "https://hdwechat.hengdianworld.com/jump?id=1541"
                    ],

                    [
                        "type" => "view",
                        "name" => "节目时间",
                        "url" => "https://hdwechat.hengdianworld.com/jump?id=1513"
                    ],

                    [
                        "type" => "view",
                        "name" => "剧组动态",
                        "url" => "https://hdwechat.hengdianworld.com/jump?id=1512"
                    ],
                    [
                        "type" => "view",
                        "name" => "游玩攻略",
                        "url" => "https://hdwechat.hengdianworld.com/jump?id=1511"
                    ],
                    [
                        "type" => "view",
                        "name" => "在线客服",
                        "url" => "https://hdwechat.hengdianworld.com/jump?id=1540"
                    ],
                ],
            ],
            [
                "name" => "购票中心",
                "sub_button" => [
                    [
                        "type" => "view",
                        "name" => "最新活动",
                        "url" => "https://hdwechat.hengdianworld.com/jump?id=1542"
                    ],
                    [
                        "type" => "view",
                        "name" => "官方福利",
                        "url" => "https://hdwechat.hengdianworld.com/jump?id=1543"
                    ],
                    [
                        "type" => "view",
                        "name" => "门票预定",
                        "url" => "https://hdwechat.hengdianworld.com/jump?id=1520"
                    ],
                    [
                        "type" => "view",
                        "name" => "酒景套餐",
                        "url" => "https://hdwechat.hengdianworld.com/jump?id=1521"
                    ],

                    [
                        "type" => "view",
                        "name" => "订单查询",
                        "url" => "https://hdwechat.hengdianworld.com/jump?id=1516"
                    ],

                ],
            ],
            [
                "name" => "酒店中心",
                "sub_button" => [
                    [
                        "type" => "miniprogram",
                        "name" => "特惠商城",
                        "url" => "https://wx3e632d57ac5dcc68.wx.gcihotel.net/mall2/?/=#/",
                        "appid" => "wxec43a205882c487f",
                        "pagepath" => "/pages/mall/index"
                    ],
                    [
                        "type" => "miniprogram",
                        "name" => "特色美食",
                        "url" => "http://m.hengdianworld.com/info_jq.aspx",
                        "appid" => "wxec43a205882c487f",
                        "pagepath" => "/pages/mall/typeIndex?typeId=640148dbcee14636a4e9f0bdde302a5e"
                    ],
                    [
                        "type" => "miniprogram",
                        "name" => "特惠客房",
                        "url" => "http://wx3e632d57ac5dcc68.wx.gcihotel.net/wechat/?/=#/bookSearch",
                        "appid" => "wxec43a205882c487f",
                        "pagepath" => "/pages/mall/typeIndex?typeId=d5d542f9fd2647be815341c89fe38f5d"
                    ],
                    /*[
                        "type" => "view",
                        "name" => "我要大奖",
                        "url" => "https://hdwechat.hengdianworld.com/jump?id=1546"
                    ],*/
                    /*[
                        "type" => "miniprogram",
                        "name" => "限时抢购",
                        "url" => "http://m.hengdianworld.com/info_yyx.aspx",
                        "appid" => "wxec43a205882c487f",
                        "pagepath" => "/pages/mall/typeIndex?typeId=7c873700ab66483abb4b79993039ea5a"
                    ],*/
                    [
                        "type" => "view",
                        "name" => "员工登录",
                        "url" => "https://wx3e632d57ac5dcc68.wx.gcihotel.net/wechat/?/#/distributorApply"
                        /* "appid"=>"wxec43a205882c487f",
                         "pagepath"=>"/pages/mall/typeIndex?typeId=d5d542f9fd2647be815341c89fe38f5d"*/
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
