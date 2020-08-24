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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login','ProfLoginController@index');

Route::resource('prof','ProfIndexController',['only'=>[
    'index','store','update','destroy'
]]);

Route::resource('prof','ProfIndexController',['except'=>[
    'create','edit','show'
]]);

Route::resource('meeting','MeetingController',['only'=>[
    'index','create','store','destroy'
]]);

Route::resource('meeting','MeetingController',['except'=>[
    'edit','show','update'
]]);

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
