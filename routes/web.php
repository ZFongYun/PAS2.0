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

//Route::get('/profIndex','ProfIndexController@index');

Route::get('/login','ProfLoginController@index');

Route::resource('prof','ProfIndexController',['only'=>[
    'index','store','update','destroy'
]]);

Route::resource('prof','ProfIndexController',['except'=>[
    'create','edit','show'
]]);
