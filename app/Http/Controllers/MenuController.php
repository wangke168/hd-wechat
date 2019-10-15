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
                "name" => "会议会展",
                "sub_button" => [
                    [
                        "type" => "view",
                        "name" => "酒店会场",
                        "url" => "https://mp.weixin.qq.com/s/uYGh32ht_Tz0XkIRbwJoug"
                    ],
                    [
                        "type" => "view",
                        "name" => "景区剧场",
                        "url" => "https://mp.weixin.qq.com/s/blcC9BMEDviELXFoonYxdg"
                    ],
                    [
                        "type" => "view",
                        "name" => "特色资源",
                        "url" => "https://mp.weixin.qq.com/s/vyKJt8EtOa0lAbvHDFgjug"
                    ],
                    [
                        "type" => "view",
                        "name" => "穿越主题会议",
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
                "name" => "活动赛事",
                "sub_button" => [
                    [
                        "type" => "click",
                        "name" => "品牌赛事",
                        "key" => "1"
                    ],
                    [
                        "type" => "view",
                        "name" => "儿童电影节",
                        "url" => "https://mp.weixin.qq.com/s/8GWBO7eNtkk9AMl4TpM4sQ"
                    ],
                    [
                        "type" => "view",
                        "name" => "影视旅游小姐大赛",
                        "url" => "https://mp.weixin.qq.com/s/AQKGow97mWlyZC2h41y4Og"
                    ],
                    [
                        "type" => "view",
                        "name" => "横店影视武林会",
                        "url" => "https://mp.weixin.qq.com/s/PNxklfedA_iSHwIqFrkzyA"
                    ],
                    [
                        "type" => "click",
                        "name" => "童星盛典",
                        "key" => "2"
                    ],
                ],
            ],
            [
                "name" => "疗休养",
                "sub_button" => [
                    [
                        "type" => "view",
                        "name" => "横店景区简介",
                        "url" => "http://m.hengdianworld.com/info_jq.aspx"
                    ],
                    [
                        "type" => "view",
                        "name" => "演艺秀简介",
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
                "name" => "住宿预订",
                "sub_button" => [
                    [
                        "type" => "view",
                        "name" => "10月17号（一晚）",
                        "url" => "https://job.hdymxy.com/redirect?type=activity&id=492"
                    ],
                    [
                        "type" => "view",
                        "name" => "10月18号（一晚）",
                        "url" => "https://job.hdymxy.com/redirect?type=activity&id=493"
                    ],
               /*     [
                        "type" => "view",
                        "name" => "两晚连住",
                        "url" => "https://job.hdymxy.com/redirect?type=activity&id=494"
                    ],*/
                    [
                        "type" => "click",
                        "name" => "客服电话",
                        "key" => "100"
                    ],
                ],
            ],
     /*       [
                "name" => "门票预定",
                "sub_button" => [
                    [
                        "type" => "view",
                        "name" => "预定入口",
                        "url" => "http://e.hengdianworld.com/yd_mp_activity.aspx?id=629&uid=68756977755F6C616E646169"
                    ],
                    [
                        "type" => "view",
                        "name" => "常见问题",
                        "url" => "https://hdwechat.hengdianworld.com/article/articledetail?id=2784"
                    ],
                ],
            ],*/

            [
                "type" => "view",
                "name" => "门票预订",
                "url"  => "https://job.hdymxy.com/meeting/myq"
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
