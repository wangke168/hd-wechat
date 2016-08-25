<?php

namespace App\Http\Controllers;

use App\WeChat\Response;
use Carbon\Carbon;
use DB;
use App\Models\WechatArticle;
use Illuminate\Http\Request;
use Crypt;
use App\WeChat\usage;
use App\WeChat\tour;
use App\Http\Requests;

class ArticlesController extends Controller
{

    public function index()
    {
//        $articles = Article::all();
        $articles = DB::table('wx_article')->where('title', 'like', '门票%')->orderBy('id', 'desc')->skip(0)->take(2)->get();
//        return $articles;
        return view('articles.index', compact('articles'));
    }

    public function  show($id)
    {
        $article = WechatArticle::find($id);
//        $aaa=WechatArticle::
//        return $article;
        return view('articles.show', compact('article'));
    }

    public function detail($id)
    {
        $article = WechatArticle::find($id);
        return view('articles.detail', compact('article'));
    }

    public function info()
    {
        /*        $row=DB::table('wx_user_info')
                    ->where('wx_openid','o2e-YuBgnbLLgJGMQykhSg_V3VRI')
                    ->first();
                return $row->ID;*/
/*        $usage=new usage();
        return $usage->get_openid_info('o2e-YuBgnbLLgJGMQykhSg_V3VRI')->city;*/
//        return $usage->v('aaa','1');

        /*   $tour = new tour();
           return $tour->check_amount('1', '2');*/


        $response=new Response();
        $content=$response->request_focus('o2e-YuBgnbLLgJGMQykhSg_V3VRI', '111');
        return $content;
/*        $eventkey='111';
        $row = DB::table('wx_article')
            ->where('keyword', 'like', '%门票%')
            ->where(function ($query) use($eventkey){
                $query->where('eventkey',$eventkey)
                    ->orWhere('eventkey','all');
            })
//            ->orWhere('eventkey','all')
            ->where('audit', '1')
            ->where('del', '0')
            ->where('online', '1')
            ->where('startdate', '<=', date('Y-m-d'))
            ->where('enddate', '>=', date('Y-m-d'))
            ->orderBy('priority', 'asc')
            ->orderBy('id', 'desc')
            ->skip(0)->take(8)->lists('id');
        return $row;*/
    }

}
