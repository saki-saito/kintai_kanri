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

// ユーザー登録
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup.get');
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');

// 認証
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login.get');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::get('logout', 'Auth\LoginController@logout')->name('logout.get');

Route::get('/', 'MenusController@showTopMenu')->name('menus.top');

// 認証済ユーザーのみ
Route::group(['middleware' => ['auth']], function(){
    // 就業メニュー
    Route::get('employment', 'MenusController@showEmploymentMenu')->name('menus.employment');
    
    // // 詳細勤務入力
    // Route::get('inpwork', 'EmploymentsController@inputWork')->name('emp.inpwork');
    
    // 簡易勤務入力メニュー
    Route::get('kanni_kinmu', 'EmploymentsController@viewKanniKinmuInput')->name('emp.kanni_kinmu');
    // 簡易勤務登録 - 出勤
    Route::post('kanni_kinmu_start', 'EmploymentsController@storeKanniKinmuStart')->name('emp.kanni_kinmu_start');
    // 簡易勤務登録 - 退勤
    Route::post('kanni_kinmu_end', 'EmploymentsController@storeKanniKinmuEnd')->name('emp.kanni_kinmu_end');
    
    
    
    // Route::group(['prefix' => 'users/{auth_id}'], function(){
    //     // 勤怠入力-出勤
    //     Route::post('storework', 'EmploymentsController@storeWork')->name('emp.storework');
        // // 勤怠入力-出勤
        // Route::post('leaveWork', 'UserFollowController@store')->name('user.follow');
    // });
});