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

Route::get('/', 'TasksController@index');
//    return view ('welcome');

//認証付きのルーティング
Route::group(['middleware' => ['auth']], function () {
    // 中略
    Route::resource('tasks','TasksController', ['only' => ['index','show']]);
    Route::resource('tasks','TasksController', ['only' => ['edit','update']]);
    Route::resource('tasks','TasksController',['only'=> ['store','create']]);
    Route::resource('tasks', 'TasksController', ['only' => ['store', 'destroy']]);
});


//Route::resource('tasks', 'TasksController');

// 認証
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::get('logout', 'Auth\LoginController@logout')->name('logout.get');

// ユーザ登録
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup.get');
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');
