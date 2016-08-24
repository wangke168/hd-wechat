<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\WeChat\tour;
use App\Http\Requests;

class ZoneController extends Controller
{
    //
    public function ldjl($openid)
    {
        return view('subscribe.ldjl', ['openid' => $openid]);
    }

    public function subscribe($openid)
    {
        $tour = new tour();
        return $tour->subscribe($openid,'1');
//        return 'sadas';
    }

}
