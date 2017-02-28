<?php

namespace App\Http\Controllers;


use App\Http\Requests;
use EasyWeChat\Foundation\Application;

class TokenController extends Controller
{
    public $app;
    public $js;
    public function __construct(Application $app)
    {
        $this->app=$app;

        $this->js=$this->app->js;
    }

    //
    public function token()
    {
        return $this->app->access_token->getToken();
    }
    public function js()
    {
        $ticket=$this->js->ticket();
        $data = ['ticket'=>$ticket];
        return response()->json($data);
//        return $ticket;
    }
    public function getjs()
    {
        $token_url = "http://wechat-2.unclewang.me/api";
        $result = file_get_contents($token_url);

        $result=json_decode($result,true);
        echo $result['ticket'].'<br>';
        echo $result['token'];
//        return $ticket;
    }

    public function api()
    {
        $token=$this->app->access_token->getToken();
        $ticket=$this->js->ticket();
        $data=['token'=>$token,'ticket'=>$ticket];
        return response()->json($data);
    }
}
