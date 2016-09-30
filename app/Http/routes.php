<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::any('/wechat', 'WechatController@serve');
//输出token
Route::get('/hd-token','TokenController@token');
Route::get('/jump/{id}/{openid}','LinkJumpController@index');

//订单相关
Route::get('/ordersend/{sellid}/{openid}','OrderController@send');
Route::get('/orderconfrim/{sellid}/{openid?}','OrderController@confrim');


/*
Route::get('/', function () {
    return view('welcome');
});
Route::get('about', function () {
    return 'Hello World';
});
*/

Route::get('/articles', 'ArticlesController@index');
Route::get('/articles/{id}', 'ArticlesController@detail');

//预约系统
Route::get('/zone/subscribe/ldjl/{openid}','ZoneController@ldjl');
Route::get('/zone/subscribe/ldjl/get_subscribe/{project_id}/{openid}','ZoneController@subscribe');



Route::get('/info', 'ArticlesController@info');
Route::get('/queue','ArticlesController@queue');
Route::get('/info/{sellid}/{openid?}', 'ArticlesController@info');
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



//测试
Route::get('/test/updateopenidinfo','TestController@update_openid_info');
Route::get('test/updateescinfo','TestController@update_esc_info');
Route::get('/test/updateclickinfo','TestController@update_click_info');
Route::get('/test/ordersend/{id}/{openid?}','TestController@order_send');
Route::get('test/orderconfrim/{id}/{openid?}','TestController@order_confrim');