<?php

namespace App\Http\Controllers;

use App\WeChat\Count;
use App\WeChat\Usage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\WeChat\OpenID;

class LinkJumpController extends Controller
{
    public function index(Request $request)
    {
        $id = $request->input("id");




        $jump_url = env('JUMP_URL', '');
        $get_openid_url = $jump_url . "?id=" . $id;

        /**通过H5获取用户OpenID**/
        $openid = new OpenID();
        $wxnumber = $openid->GetOpenid($get_openid_url);
        /**------------------**/

//        $wxnumber='o2e-YuBvWwFSt4eoBARCRe8o2104';
        /**计数**/
        $count = new Count();
        $count->add_article_hits($id);
        $count->insert_hits($id, $wxnumber);
//        $this->addclick($id,$openid);
        $usage = new Usage();
        $eventkey = $usage->get_openid_info($wxnumber)->eventkey;

        if ($this->check_chuangkou($eventkey)) {
            if ($id == "1520") {
                $id = "1538";
            }
            if ($id == "1521") {
                $id = "1538";
            }
            if ($id == "1522") {
                $id = "1538";
            }
        }


        $uid = $usage->get_uid($wxnumber);
//        $uid = "";
        $wxnumber = $usage->authcode($wxnumber, 'ENCODE', 0);

        $url = $this->get_url($id)->url;
        if (!strstr($url, 'project_id')) {
            if (strstr($url, '?') != '') {
                $url = $url . "&comefrom=1&wxnumber={$wxnumber}&uid={$uid}&wpay=1";
            } else {
                $url = $url . "?comefrom=1&wxnumber={$wxnumber}&uid={$uid}&wpay=1";
            }
            return redirect($url);
        } else {
            return redirect($url . "&wxnumber={$wxnumber}");
        }
    }

    /**
     * 检测是不是窗口扫码的eventkey
     * @param $eventkey
     * @return bool
     */
    private function check_chuangkou($eventkey){

        $row=DB::table('wx_qrscene_info')
            ->where('qrscene_id',$eventkey)
            ->where('classid','9')
            ->first();
        if ($row)
        {
            $flag= true;
        }
        else{
            $flag=false;
        }
        return $flag;
    }

    /* public function index($id, $openid)
     {
         $count = new Count();
         $count->add_article_hits($id);
         $count->insert_hits($id, $openid);
 //        $this->addclick($id,$openid);
         $usage = new Usage();
         $wxnumber = $usage->authcode($openid, 'ENCODE', 0);
         $uid = $usage->get_uid($openid);
         $url = $this->get_url($id)->url;
         if (!strstr($url, 'project_id')) {
             if (strstr($url, '?') != '') {
                 $url = $url . "&comefrom=1&wxnumber={$wxnumber}&uid={$uid}&wpay=1";
             } else {
                 $url = $url . "?comefrom=1&wxnumber={$wxnumber}&uid={$uid}&wpay=1";
             }
             return redirect($url);
         } else {
             return redirect($url . "&wxnumber={$openid}");
         }
     }*/

    private function CheckCardBan($eventkey)
    {
        $row = DB::table('wx_card_ban')
            ->where('id', 1)
            ->first();

        if ($eventkey == '') {
            return false;
        } else {
            $tmparray = explode($eventkey, $row->eventkey);
            if (count($tmparray) > 1) {
                return true;
            } else {
                return false;
            }
        }

    }

    private function addclick($id, $openid)
    {
        DB::table('wx_article_hits')
            ->insert(['article_id' => $id, 'wx_openid' => $openid]);
        DB::table('wx_article')
            ->where('id', $id)
            ->increment('hits');
    }

    private function get_url($id)
    {
        $row = DB::table('wx_article')
            ->where('id', $id)
            ->first();
        return $row;
    }

    /**
     * 订阅号跳转
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function jump_dyh()
    {
        $url = 'http://m.hdyuanmingxinyuan.com/default.aspx?wxnumber=1e23iMtHGSQCf4yLlXXSGEiQWM2W3[c]gqlPVSTzZzW1KIG5[a]y';
        return redirect($url);
    }

    /**
     * 集团公众号跳转
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function jump_jt()
    {
        $url = 'http://m.hdyuanmingxinyuan.com/default.aspx?wxnumber=ec8ceIgJl9DcyD4ZestC8KhkKL35yRYab0tzWDTmGijts[c]qStiYqVhAoTCC4EtG8rRU';
        return redirect($url);
    }

    /**
     * 直接跳转
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function jd(Request $request)
    {
        $id = $request->input("id");
        $count = new Count();
        $count->add_article_hits($id);
        $count->insert_hits($id, "temp");
        $url = $this->get_url($id)->url;
        return redirect($url);
    }


    public function jump_mobile(Request $request)
    {
        $wxnumber = $request->input('wxnumber');
        $usage = new Usage();
        $uid = $usage->get_uid($wxnumber);
        $wxnumber = $usage->authcode($wxnumber, 'ENCODE', 0);
        return redirect("http://m.hdyuanmingxinyuan.com?wxnumber=" . $wxnumber . "&uid=" . $uid);
    }

}
