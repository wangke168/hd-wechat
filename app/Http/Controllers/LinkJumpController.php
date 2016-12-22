<?php

namespace App\Http\Controllers;

use App\WeChat\Count;
use App\WeChat\Usage;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests;

class LinkJumpController extends Controller
{
    public function index($id, $openid)
    {

        $count=new Count();
        $count->add_article_hits($id);
        $count->insert_hits($id,$openid);
//        $this->addclick($id,$openid);
        $usage = new Usage();
        $wxnumber = $usage->authcode($openid, 'ENCODE', 0);
        $uid = $usage->get_uid($openid);
        $url = $this->get_url($id)->url;
/*        if (strstr($url, '?') != '') {
            $url = $url . "&comefrom=1&wxnumber={$wxnumber}&uid={$uid}&wpay=1";
        } else {
            $url = $url . "?comefrom=1&wxnumber={$wxnumber}&uid={$uid}&wpay=1";
        }*/
        return redirect($url);
    }

    private function addclick($id, $openid)
    {
        DB::table('wx_article_hits')
            ->insert(['article_id'=>$id,'wx_openid'=>$openid]);
        DB::table('wx_article')
            ->where('id',$id)
            ->increment('hits');
    }

    private function get_url($id)
    {
        $row = DB::table('wx_article')
            ->where('id', $id)
            ->first();
        return $row;
    }

    public function jump_dyh()
    {
        $url='http://m.hengdianworld.com/default.aspx?wxnumber=1e23iMtHGSQCf4yLlXXSGEiQWM2W3[c]gqlPVSTzZzW1KIG5[a]y';
        return redirect($url);
    }
}
