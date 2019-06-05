<?php


Route::any('/wechat', 'WechatController@serve');
//输出token
Route::get('/hd-token','TokenController@token');
Route::get('/api','TokenController@api');

Route::get('/api/getjs','TokenController@getjs');

//跳转
Route::get('/jump/{id}/{openid}','LinkJumpController@index');
Route::get('/jump/ehengdian','LinkJumpController@jump_dyh');
Route::get('/jump/jt','LinkJumpController@jump_jt');
//菜单跳转手机官网
Route::get('/jump/mobile','LinkJumpController@jump_mobile');

//订单相关
Route::get('/ordersend/{sellid}/{openid}','Order\OrderController@send');
Route::get('/orderconfrim/{sellid}/{openid}','Order\OrderController@confrim');

//二次营销
Route::get('/secondarticle/{sellid}/{openid}/{info_id}','ArticlesController@second_article');
//二次营销阅读
Route::get('/searticledetail','ArticlesController@second_article_detail');


Route::get('/', function () {
    return view('welcome');
});
Route::get('/info_jq_detail', 'IndexController@JQ');
Route::get('/info_detail', 'IndexController@InfoDetail');
Route::get('about', function () {
    return 'Hello World';
});

//数据统计

Route::get('/count/{type}/{id}/{openid?}','CountController@CountArticle');



//Route::get('/articles', 'ArticlesController@index');
//Route::get('/article', 'ArticlesController@detail');

//文章管理
Route::get('/article/detail', 'ArticlesController@detail');
//Route::get('/article/test', 'ArticlesController@detail_long');

//Route::get('/article/test/short', 'ArticlesController@detail_short');

Route::get('/article/webdetail','ArticlesController@webdetail');
Route::get('/article/detail_back', 'ArticlesController@test');
//预览
Route::get('/article/review', 'ArticlesController@detail_review');

//预约系统

Route::get('/zone/subscribe/ldjl','ZoneController@ldjl');
Route::get('/zone/subscribe/get','ZoneController@subscribe');


//菜单跳转手机官网





//菜单及自定义菜单
Route::get('/menu','MenuController@menu');
Route::get('/menu/add','MenuController@add');
Route::get('/menu/index','MenuController@index');
/*{
    if ($openid)
    return $openid;
    else
        return 'null';
});*/


//卡券测试
Route::get('/card', 'CardController@index');
Route::get('/cardcreate', 'CardController@create');

//用户相关测试
Route::get('/users','UserController@users');
Route::get('/user/{openId}','UserController@user');
//wx_click_hits  获取openid的eventkey并update
Route::get('/update','UserController@update');


//素材管理
Route::get('/audio','MaterialController@audio');

//获取门店信息
Route::get('/shop_info','ShopController@index');

//队列测试
Route::get('/queue','QueueController@queue');

//jssdk测试
Route::get('/jssdk','JssdkController@index');
Route::get('/jssdk/test','JssdkController@test');


//测试
Route::get('/test/updateopenidinfo','TestController@update_openid_info');
Route::get('/test/updateescinfo','TestController@update_esc_info');
Route::get('/test/updateclickinfo','TestController@update_click_info');
Route::get('/test/ordersend/{id}/{openid?}','TestController@order_send');
Route::get('/test/orderconfrim/{id}/{openid?}','TestController@order_confrim');

Route::get('/test/test','Test\TestController@test');

Route::get('/test/article/detail', 'Test\TestController@detail_test');

Route::get('temp',function(){
    return Redirect::to('http://w.unclewang.me/zone/subscribe/ldjl?comefrom=1&wxnumber=f764R1Xw49kFEKrCNbiXfw7lYjeHzBlSgjGw98IX8[a]63226WuP4D9pTQ3rGph6j[c]4ccyH1hulpBW&uid=&wpay=1');
});



/*Route::get('article', function(){
//    $book = Input::get('openid');
//    'Test\ArticleController@test';
    return $book;
});*/
//Route::get('article','Test\ArticleController@test');
