<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use DB;
use App\Models\WechatArticle;
use Illuminate\Http\Request;

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
//        $usage=new usage();
//        return $usage->get_openid_info('o2e-YuBgnbLLgJGMQykhSg_V3VRI')->city;
//        return $usage->v('aaa','1');

     /*   $tour = new tour();
        return $tour->check_amount('1', '2');*/
        $row=DB::table('tour_zone_class')
            ->whereRaw('id=(select zone_classid from tour_project_class where id=1)')
            ->first();
        if ($row) {
            return $row->zone_name;
        } else {
            return "该景区不存在";
        }
    }

}
