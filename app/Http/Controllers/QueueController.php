<?php

namespace App\Http\Controllers;

use App\Jobs\TestQueue;
use Illuminate\Http\Request;

use App\Http\Requests;
use DB;

class QueueController extends Controller
{
    //
    public function queue()
    {
       $row=DB::table('wx_click_hits')
           ->where('id','>','0')
           ->where('id','<','61')
           ->get();
        foreach ($row as $openid)
        {
            $this->dispatch(new TestQueue($openid));
        }
        return 'Done';
    }
}
