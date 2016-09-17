<?php

namespace App\Http\Controllers;

use App\Jobs\TestQueue;
use App\Jobs\UpdateQueue;
use Illuminate\Http\Request;

use App\Http\Requests;
use DB;

class QueueController extends Controller
{
    //
    public function queue()
    {
/*       $row=DB::table('wx_click_hits')
           ->whereDate('adddate','>','2016-8-28')

           ->get();
        foreach ($row as $openid)
        {
            $this->dispatch(new TestQueue($openid));
        }*/

        $row = DB::table('wx_user_info')
            ->where('esc', '0')
            ->where('id', '>=', '427039')
            ->orderBy('id','desc')
            ->get();
        foreach ($row as $OpenidInfo)
        {
            $this->dispatch(new UpdateQueue($OpenidInfo));
        }
        
        return 'Done';
    }
}
