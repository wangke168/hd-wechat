<?php

namespace App\Http\Controllers;

use EasyWeChat\Foundation\Application;
use Illuminate\Http\Request;

use App\Http\Requests;

class CardController extends Controller
{
    public $app;
    public $card;

    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->card = $app->card;
    }

    public function index()
    {
        $offset = 0;
        $count = 10;
        //CARD_STATUS_NOT_VERIFY,待审核；
        //CARD_STATUS_VERIFY_FAIL,审核失败；
        //CARD_STATUS_VERIFY_OK，通过审核；
        //CARD_STATUS_USER_DELETE，卡券被商户删除；
        //CARD_STATUS_DISPATCH，在公众平台投放过的卡券；
        $statusList = 'CARD_STATUS_VERIFY_OK';
        $result = $this->card->lists($offset, $count, $statusList);
        return $result;
    }
    
    public function create()
    {

        $cardType = 'GIFT';
        $baseInfo = [
            'logo_url' => 'http://mmbiz.qpic.cn/mmbiz/2aJY6aCPatSeibYAyy7yct9zJXL9WsNVL4JdkTbBr184gNWS6nibcA75Hia9CqxicsqjYiaw2xuxYZiaibkmORS2oovdg/0',
            'brand_name' => 'MV优惠券测试',
            'code_type' => 'CODE_TYPE_QRCODE',
            'title' => '测试',
            'sub_title' => '测试副标题',
            'color' => 'Color010',
            'notice' => '测试使用时请出示此券',
            'service_phone' => '15311931577',
            'description' => "测试不可与其他优惠同享\n如需团购券发票，请在消费时向商户提出\n店内均可使用，仅限堂食",
            'date_info' => [
                'type' => 'DATE_TYPE_FIX_TERM',
                'fixed_term' => 90, //表示自领取后多少天内有效，不支持填写0
                'fixed_begin_term' => 0, //表示自领取后多少天开始生效，领取后当天生效填写0。
            ],
            'sku' => [
                'quantity' => '0', //自定义code时设置库存为0
            ],
            'location_id_list' => ['461907340'],  //获取门店位置poi_id，具备线下门店的商户为必填
            'get_limit' => 1,
            'use_custom_code' => true, //自定义code时必须为true
            'get_custom_code_mode' => 'GET_CUSTOM_CODE_MODE_DEPOSIT',  //自定义code时设置
            'bind_openid' => false,
            'can_share' => true,
            'can_give_friend' => false,
            'center_title' => '顶部居中按钮',
            'center_sub_title' => '按钮下方的wording',
            'center_url' => 'http://www.qq.com',
            'custom_url_name' => '立即使用',
            'custom_url' => 'http://www.qq.com',
            'custom_url_sub_title' => '6个汉字tips',
            'promotion_url_name' => '更多优惠',
            'promotion_url' => 'http://www.qq.com',
            'source' => '造梦空间',
        ];
        $especial = [
            'deal_detail' => 'deal_detail',
        ];
        $result = $this->card->create($cardType, $baseInfo, $especial);
        return $result;
    }
    
}
