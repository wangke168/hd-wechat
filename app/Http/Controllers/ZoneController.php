<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class ZoneController extends Controller
{
    //
    public function ldjl($openid)
    {
        return view('subscribe.ldjl',['openid'=>$openid]);
    }
}
