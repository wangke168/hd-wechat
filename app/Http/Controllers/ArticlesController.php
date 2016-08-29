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
        $text='天气';
        $flag = "不包含";
//        $row = $db->query("select keyword from WX_Request_Keyword order by id asc", PDO::FETCH_NUM);

        $row=DB::table('wx_request_keyword')
            ->orderBy('id','asc')->get();

        foreach ($row as $result) {
            if (@strstr($text, $result['keyword']) != '') {
                $flag = $result['keyword'];
                //              $flag = "bbb";
                break;
            }
        }
        return $flag;

/*        $usage =new usage();
        if ($usage->query_tag_id('123')) {                          //获取eventkey对应的tag
            $tag->batchTagUsers([$openid], $usage->query_tag_id('123'));          //增加标签
        }*/

//        $userTags = $tag->userTags('opUv9v977Njll_YHpZYMymxI_aPE');
//        $userTags=$tag->lists();
//        $tag->batchTagUsers([$openid], '101');
//        $userTags=$tag->usersOfTag('101');

    }

}
