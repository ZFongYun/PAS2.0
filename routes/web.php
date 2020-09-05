<?php

use Illuminate\Support\Facades\Route;

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

//Route::get('/', function () {
//    return view('welcome');
//});

//Route::get('/login','ProfLoginController@index');

Route::prefix('ProLogin')->group(function (){
    Route::get('/','ProfLoginController@index');
    Route::post('/login','ProfLoginController@login');
    Route::get('/logout','ProfLoginController@logout');
});


Route::resource('prof','ProfIndexController',['only'=>[
    'index','store','update','destroy'
]]);

Route::resource('prof','ProfIndexController',['except'=>[
    'create','edit','show'
]]);

Route::resource('meeting','MeetingController');

Route::resource('ImportStudent','ImportStudentController',['only'=>[
    'index','store','destroy'
]]);

Route::resource('ImportStudent','ImportStudentController',['except'=>[
    'edit','show','update','create'
]]);

Route::resource('GroupList','GroupListController');

Route::prefix('GroupList')->group(function (){
    Route::get('plus/{id}','GroupListController@plus_page');
    Route::post('plus/{id}','GroupListController@plus');
    Route::post('destroy_member/{id}','GroupListController@destroy_member');
});

Route::prefix('meeting')->group(function (){
    Route::get('score/{id}','MeetingController@scoring_page');
    Route::post('score','MeetingController@score');
    Route::post('scoring_team','MeetingController@scoring_team');
    Route::post('edit_team','MeetingController@edit_team');
    Route::post('scoring_stu','MeetingController@scoring_stu');
    Route::post('edit_stu','MeetingController@edit_stu');
});

Route::prefix('StuLogin')->group(function (){
    Route::get('/','StuLoginController@index');
    Route::post('/login','StuLoginController@login');
    Route::get('/logout','StuLoginController@logout');
});

Route::resource('StuIndex','StuIndexController',['only'=>[
    'index'
]]);

Route::resource('StuIndex','StuIndexController',['except'=>[
    'create','edit','show','store','update','destroy'
]]);

Route::resource('StuGroupList','StuGroupListController',['only'=>[
    'index','edit','update'
]]);

Route::resource('StuGroupList','StuGroupListController',['except'=>[
    'create','show','store','destroy'
]]);

Route::resource('ResetPassword','ResetPasswordController',['only'=>[
    'index','update'
]]);

Route::resource('ResetPassword','ResetPasswordController',['except'=>[
    'create','show','store','destroy','edit'
]]);

Route::prefix('StuMeeting')->group(function (){
    Route::get('/','StuMeetingController@index')->name('StuMeeting.index');
    Route::get('/{id}','StuMeetingController@show')->name('StuMeeting.show');
//    Route::get('/logout','StuLoginController@logout');
});
