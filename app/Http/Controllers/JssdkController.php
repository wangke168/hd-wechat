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
    public function __construct(Application $app)
    {
        $this->app=$app;
        $this->js=$this->app->js;
    }
    
    public function index()
    {
        return view('test.jssdk')->with('js',$this->js);
    }
}
