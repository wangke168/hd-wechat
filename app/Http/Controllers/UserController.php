<?php

namespace App\Http\Controllers;

use EasyWeChat\Foundation\Application;
use Illuminate\Http\Request;

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
}
