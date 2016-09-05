<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\WeChat\Tour;
use App\Http\Requests;

class ZoneController extends Controller
{
    //
    public function ldjl($openid)
    {
        return view('subscribe.ldjl', ['openid' => $openid]);
    }

    public function subscribe($openid,$project_id)
    {
        $tour = new Tour();
        return $tour->subscribe($openid,$project_id);
//        return 'sadas';
    }

}
