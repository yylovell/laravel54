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













