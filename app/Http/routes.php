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

// 首页列表
Route::get('/', 'PostsController@index');
// 帖子
Route::resource('discussions', 'PostsController');
// 评论
Route::resource('comment', 'CommentsController');


// 用户
Route::get('/user/register', 'UsersController@register');
Route::get('/user/login', 'UsersController@login');
Route::get('/user/avatar', 'UsersController@avatar'); //更好头像视图
Route::get('/verify/{confirm_code}', 'UsersController@confirmEmail');
Route::post('/user/register', 'UsersController@store');
Route::post('/user/login', 'UsersController@signin');
Route::post('/avatar', 'UsersController@changeAvatar'); //更换头像提交
Route::post('/crop/api', 'UsersController@cropAvatar'); //裁剪头像
Route::post('/post/upload', 'PostsController@upload'); // markdown上传图片



Route::get('/logout', 'UsersController@logout');














