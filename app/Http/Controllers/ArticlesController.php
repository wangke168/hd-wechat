<?php

namespace App\Http\Controllers;

use App\WeChat\Count;
use App\WeChat\Usage;
use Carbon\Carbon;
use DB;
use App\Models\WechatArticle;
use EasyWeChat\Foundation\Application;
use Illuminate\Http\Request;
use App\Http\Requests;


class ArticlesController extends Controller
{
    public $app;
    public $js;
    public $count;
    public $usage;

    public function __construct(Application $app)
    {
        $this->app = $app;
//        $this->js = $this->app->js;
        $this->count = new Count();
        $this->usage = new Usage();
    }

    /**
     * 预订成功后推送相关信息
     * @param $sellid
     * @param $openid
     * @param $info_id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function second_article($sellid, $openid, $info_id)
    {
        $usage = new Usage();
        $openid = $usage->authcode($openid, 'DECODE', 0);

        //设置se_info_send阅读
        DB::table('se_info_send')
            ->where('sellid', $sellid)
            ->where('wx_openid', $openid)
            ->where('info_id', $info_id)
            ->update(['is_read' => 1, 'readtime' => Carbon::now()]);

        //增加阅读数
        DB::table('wx_article_se')
            ->where('id', $info_id)
            ->increment('hits');

        //找出对应url并跳转
     /*   $row = DB::table('wx_article_se')
            ->where('id', $info_id)
            ->first();

        $this->count->insert_hits('1285', $openid);
        $url = 'http://e.hengdianworld.com/WeixinOpenId.aspx?nexturl=' . $row->article_url;
        return redirect($url);*/
    }

    /**
     * 打开二次推送页面
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function second_article_detail(Request $request)
    {
        $id = $request->input('id');
        $openid = $request->input('openid');
        $article = WechatArticle::find($id);
        if (!$article || $article->online == '0' || $article->enddate < Carbon::now()) {
            abort(404);
        } else {
            return view('articles.seconddetail', compact('article', 'id', 'openid'));
        }
    }


    /**
     * 文章列表测试
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $articles = DB::table('wx_article')->where('title', 'like', '门票%')->orderBy('id', 'desc')->skip(0)->take(2)->get();
        return view('articles.index', compact('articles'));
    }


    public function show($id)
    {
        $article = WechatArticle::find($id);

        return view('articles.show', compact('article'));
    }

    /**
     * 显示文章详情
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail(Request $request)
    {
        $type = $request->input('type');
        $id = $request->input('id');
        $wxnumber = $request->input('wxnumber');

        $wxnumber = $this->usage->authcode($wxnumber, 'DECODE', 0);
        $openid = $request->input('openid');

        if ($wxnumber) {
            $openid = $wxnumber;
        }

        switch ($type) {
            case 'long':
                $rows_zone = DB::table('zone')
                    ->orderBy('priority', 'asc')
                    ->get();
                return view('articles.detail_show_all', compact('rows_zone', 'openid'));
                break;
            case 'detail':
                return view('articles.detail_show_all_detail');
                break;
            case 'short':
                $zone_id = $request->input('id');
                $row_zone = DB::table('zone')
                    ->where('id', $zone_id)
                    ->first();
                return view('articles.detail_show_one', compact('row_zone'));
                break;
            case 'se':                //二次推送
                $sellid=$request->input('sellid');
                $article = DB::table('wx_article_se')
                    ->find($id);
                $this->count->add_article_se_hits($id);
                $this->count->update_article_se_read($sellid,$openid,$id);
                return view('articles.detail', compact('article', 'id', 'openid'));
                break;
            default:
                $article = WechatArticle::find($id);
                if (!$article || $article->online == '0' || $article->enddate < Carbon::now()) {
                    abort(404);
                } else {
                    $this->count->add_article_hits($id);
                    $this->count->insert_hits($id, $openid);
                    return view('articles.detail', compact('article', 'id', 'openid'));
                }
                break;
        }

    }

    /**
     * 文章预览
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail_review(Request $request)
    {
        $id = $request->input('id');

        $openid = $request->input('openid');

        $article = WechatArticle::find($id);

        return view('articles.detailreview', compact('article', 'id', 'openid'));

    }

    public function detail_long(Request $request)
    {
        $rows_zone = DB::table('zone')
            ->orderBy('priority', 'asc')
            ->get();
//        return $rows_zone;
        return view('test.detail_long_test', compact('rows_zone'));
    }

    public function detail_short(Request $request)
    {
        $zone_id = $request->input('id');

        $row_zone = DB::table('zone')
            ->where('id', $zone_id)
            ->first();
        return view('test.detail_short_test', compact('row_zone'));
    }


    /**
     * 官网使用的每日剧组动态和每周剧组动态
     * @param Request $request
     */
    public function webdetail(Request $request)
    {
        $type = $request->input('type');
        if ($type == 'day') {
            $article = WechatArticle::find('37');
        } elseif ($type == 'week') {
            $article = WechatArticle::find('38');
        }
        return view('articles.webdetail', compact('article'));
    }

    public function test(Request $request)
    {
        $id = $request->input('id');
        $wxnumber = $request->input('wxnumber');

        $wxnumber = $this->usage->authcode($wxnumber, 'DECODE', 0);
        $openid = $request->input('openid');

        if ($wxnumber) {
            $openid = $wxnumber;
        }

        $article = WechatArticle::find($id);
        if (!$article || $article->online == '0' || $article->enddate < Carbon::now()) {
            abort(404);
        } else {

            $this->count->add_article_hits($id);
            $this->count->insert_hits($id, $openid);

            return view('articles.detail_back', compact('article', 'id', 'openid'));
        }
    }
}
