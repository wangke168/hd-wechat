<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class TokenController extends Controller
{
    //
    public function token()
    {
        $app = app('wechat');
        return $app->access_token->getToken();
    }
}
