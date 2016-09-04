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
Route::get('/zone/subscribe/ldjl/get_subscribe/{openid}','ZoneController@subscribe');

//测试
Route::get('/info', 'ArticlesController@info');
Route::get('/queue','ArticlesCOntroller@queue');

//输出token
Route::get('/hd-token','TokenController@token');

//素材管理
Route::get('/audio','MaterialController@audio');

//获取门店信息
Route::get('/shop_info','ShopController@index');

Route::get('/users','UserController@users');
Route::get('/user/{openId}','UserController@user');

Route::any('/wechat', 'WechatController@serve');

