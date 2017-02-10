<?php

namespace App\Http\Controllers;

use App\WeChat\Count;
use Illuminate\Http\Request;

use App\Http\Requests;
use DB;

class CountController extends Controller
{
    public function CountArticle($type,$id,$openid=null)
    {
        $count=new Count();
        switch ($type){
            case 'addresp':
                $count->add_article_resp($id);
                $count->insert_resp($id,$openid);
                break;
            case 'cancelresp':
                break;
            case 'addrespf':
                $count->add_article_respf($id);
                break;
            case 'cancelrespf':
                break;
            default:
                break;
        }
    }
}
