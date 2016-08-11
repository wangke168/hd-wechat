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
        $articles=DB::table('wx_article')->where('title','like','门票%')->orderBy('id','desc')->skip(0)->take(5)->get();
        return $articles;
//        return view('articles.index', compact('articles'));
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
}
