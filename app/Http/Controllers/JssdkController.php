<?php

namespace App\Http\Controllers;

use EasyWeChat\Foundation\Application;
use Illuminate\Http\Request;

use App\Http\Requests;

class JssdkController extends Controller
{
    //
    public $app;
    public $js;
    public $card;
    public function __construct(Application $app)
    {
        $this->app=$app;
        $this->js=$this->app->js;
        $this->card = $this->app->card;
    }
    
    public function index()
    {
        $cardinfo=$this->card->attachExtension('p2e-YuLyjE-EbQpZd3-F2-ayqAfQ');
            return view('test.jssdk')->with(['js'=>$this->js,'cardinfo'=>$cardinfo]);

    }
    public function test($openid)
    {
//        $cardinfo=$this->card->attachExtension('p2e-YuLyjE-EbQpZd3-F2-ayqAfQ');
        return view('zone.ldjl')->with(['js'=>$this->js,'openid' => $openid]);

    }
}
