<?php

namespace App\Http\Controllers;

use App\WeChat\Usage;
use EasyWeChat\Foundation\Application;
use Illuminate\Http\Request;
use DB;
use App\WeChat\Tour;
use App\Http\Requests;

class ZoneController extends Controller
{
    public $app;
    public $js;

    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->js = $this->app->js;
        $this->card = $this->app->card;
    }

    public function ldjl(Request $request)
    {
        $usage = new Usage();
        $action = $request->input('action');
        $openid = $request->input('wxnumber');
        switch ($action) {
            case 'get_subscribe':
                $project_id = $request->input('project_id');
                $tour = new Tour();
                return $tour->subscribe($openid, $project_id);
                break;
            default:
                $openid = $usage->authcode($openid, 'ENCODE', 0);
                return view('subscribe.ldjl', compact('openid'));
                break;
        }
//        $openid = $usage->authcode($openid, 'ENCODE', 0);


//        return view('subscribe.ldjl', ['openid' => $openid]);
    }

    public function test($openid)
    {
//        $cardinfo=$this->card->attachExtension('p2e-YuLyjE-EbQpZd3-F2-ayqAfQ');
        return view('zone.ldjl')->with(['js' => $this->js, 'openid' => $openid]);

    }

    public function subscribe($project_id, $openid)
    {
        $tour = new Tour();
        return $tour->subscribe($openid, $project_id);
//        return 'sadas';
    }

}
