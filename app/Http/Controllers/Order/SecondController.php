<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use EasyWeChat\Foundation\Application;
use Illuminate\Http\Request;

use App\Http\Requests;

class SecondController extends Controller
{
    public $app;
    public $notice;

    public function __construct(Application $app)
    {
        $this->app=$app;
        $this->notice=$app->notice;
    }



}
