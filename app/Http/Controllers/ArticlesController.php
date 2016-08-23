<?php

namespace App\Http\Controllers;

use DB;
use App\Models\WechatArticle;
use Illuminate\Http\Request;

use App\Http\Requests;

class ArticlesController extends Controller
{

    public function index()
    {
//        $articles = Article::all();
        $articles=DB::table('wx_article')->where('title','like','门票%')->orderBy('id','desc')->skip(0)->take(2)->get();
//        return $articles;
        return view('articles.index', compact('articles'));
    }

    public function  show($id)
    {
        $article=WechatArticle::find($id);
//        $aaa=WechatArticle::
//        return $article;
        return view('articles.show',compact('article'));
    }

    public function detail($id)
    {
        $article=WechatArticle::find($id);
        return view('articles.detail',compact('article'));
    }

    public function info(){
        $row=DB::table('wx_user_info')
            ->where('wx_openid','o2e-YuBgnbLLgJGMQykhSg_V3VRI')
            ->first();
        return $row->ID;
    }
}
