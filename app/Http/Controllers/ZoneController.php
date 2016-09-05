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

    public function subscribe($project_id,$openid)
    {
        $tour = new Tour();
        echo $tour->subscribe($openid,$project_id);
//        return 'sadas';
    }

}
