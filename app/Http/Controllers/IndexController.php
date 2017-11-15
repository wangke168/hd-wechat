<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
class IndexController extends Controller
{
    //

    public function JQ(Request $request)
    {
        $ID=$request->input('id');
        if($ID){
            $row=DB::table('zone')
                ->where('id',$ID)
                ->first();
            return view('jq_info_detail',compact('row'));
        }
        else{
            $rows=DB::table('zone')
                ->where('online','1')
                ->orderBy('priority','asc')
                ->get();
            return view('jq_info',compact('rows'));
        }
    }

    public function InfoDetail(Request $request)
    {
        $id=$request->get('id');

            $result = DB::table('wap_announcement')
                ->where('id', $id)
                ->first();
            if ($result) {
                return view('info_detail', compact('result'));
            }else{
                return view('errors.404');
            }

    }
}
