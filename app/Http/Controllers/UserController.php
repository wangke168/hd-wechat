<?php

namespace App\Http\Controllers;

use EasyWeChat\Foundation\Application;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests;

class UserController extends Controller
{
    public $wechat;

    /**
     * @param Application $wechat
     */
    public function __construct(Application $wechat)
    {
        $this->wechat=$wechat;
    }

    public function users()
    {
        $users=$this->wechat->user->lists();
        return $users;
    }
    
    public function update()
    {
        $row=DB::table('wx_click_hits')
            ->whereDate('adddate','>','2016-8-28')
            ->pluck('id');
        foreach ($row as $openid)
        {
            
/*            $eventkey_info=DB::table('wx_user_info')
                ->where('wx_openid',$openid)
                ->get();*/
//            echo $openid;
        }
        return $row;
    }
    
}
