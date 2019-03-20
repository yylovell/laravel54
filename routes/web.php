<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/', '[控制器]@[行为]');
// 注册
Route::get('/register', 'RegisterController@index');
Route::post('/register', 'RegisterController@register');

// 登录
Route::get('/login', 'LoginController@index');
Route::post('/login', 'LoginController@login');
Route::get('/logout', 'LoginController@logout');

//个人设置页面
Route::get('/user/me/setting', 'UserController@setting');
Route::post('/user/me/setting', 'UserController@settingStore');


// 文章
//
Route::get('/posts', 'PostController@index');
//
Route::get('/posts/create', 'PostController@create');
//
Route::post('/posts', 'PostController@store');
// 搜索
Route::get('/posts/search', 'PostController@search');
//
Route::get('/posts/{post}', 'PostController@show');
//
Route::get('/posts/{post}/edit', 'PostController@edit');
//
Route::put('/posts/{post}', 'PostController@update');
//
Route::get('/posts/{post}/delete', 'PostController@delete');
//
Route::post('/posts/image/upload', 'PostController@imageUpload');


// 评论

// 提交评论
Route::post('/posts/{post}/comment', 'PostController@comment');


// 点赞

//
Route::get('/posts/{post}/zan', 'PostController@zan');
//
Route::get('/posts/{post}/unzan', 'PostController@unzan');


// 个人中心

Route::get('/user/{user}', 'UserController@show');
Route::post('/user/{user}/fan', 'UserController@fan');
Route::post('/user/{user}/unfan', 'UserController@unfan');
Route::get('/user/{user}', 'UserController@show');


// 专题

Route::get('/topic/{topic}', 'TopicController@show');

Route::post('/topic/{topic}/submit', 'TopicController@submit');











