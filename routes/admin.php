<?php
Route::group(['prefix' => 'admin'], function (){
    // 登录展示页面
   Route::get('/login', '\App\Admin\Controllers\LoginController@index');
   // 登录行为
   Route::post('/login', '\App\Admin\Controllers\LoginController@login');
   // 登出
   Route::get('/logout', '\App\Admin\Controllers\LoginController@logout');


   Route::group(['middleware' => 'auth:admin'], function (){
       // 首页
       Route::get('/home', '\App\Admin\Controllers\HomeController@index');

       Route::get('/users', '\App\Admin\Controllers\UserController@index');
       Route::get('/users/create', '\App\Admin\Controllers\UserController@create');
       Route::post('/users/store', '\App\Admin\Controllers\UserController@store');
       Route::get('/users/{user}/role', '\App\Admin\Controllers\UserController@role');
       Route::post('/users/{user}/role', '\App\Admin\Controllers\UserController@storeRole');

   });

});