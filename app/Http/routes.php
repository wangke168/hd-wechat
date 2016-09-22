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


Route::get('/', function () {
    return view('welcome');
});
Route::get('about', function () {
    return 'Hello World';
});


Route::get('/articles', 'ArticlesController@index');
Route::get('/articles/{id}', 'ArticlesController@detail');

//预约系统
Route::get('/zone/subscribe/ldjl/{openid}','ZoneController@ldjl');
Route::get('/zone/subscribe/ldjl/get_subscribe/{project_id}/{openid}','ZoneController@subscribe');

//订单相关
Route::get('/sendorder/{openid}/{sellid}','OrderController@send');

//测试
Route::get('/info', 'ArticlesController@info');
Route::get('/queue','ArticlesController@queue');

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