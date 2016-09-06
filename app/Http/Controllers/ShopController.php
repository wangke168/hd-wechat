<?php

namespace App\Http\Controllers;

use EasyWeChat\Foundation\Application;
use Illuminate\Http\Request;

use App\Http\Requests;

class ShopController extends Controller
{
    //
    public $app;

    function __construct(Application $app)
    {
        // TODO: Implement __construct() method.
        $this->app=$app;
    }

    public function index()
    {
        $poi = $this->app->poi;
        return $poi->lists(0, 8);
    }
}
