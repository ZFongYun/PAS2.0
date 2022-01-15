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

Route::prefix('APS_teacher')->group(function (){
    // 教師登入
    Route::prefix('login')->group(function (){
        Route::get('/','ProfLoginController@index');
        Route::post('/authenticate','ProfLoginController@login');
        Route::get('/logout','ProfLoginController@logout');
    });

    Route::group(['middleware' => 'auth.teacher'], function() {
        //====首頁====
        Route::get('/', 'ProfIndexController@index')->name('Overall.index');
        Route::post('/store', 'ProfIndexController@store')->name('Overall.store');
        Route::DELETE('/{id}/destroy', 'ProfIndexController@destroy')->name('Overall.destroy');
        Route::put('/{id}/update', 'ProfIndexController@update')->name('Overall.update');

        //====成員名單====
        Route::resource('ImportStudent','ImportStudentController',['only'=>[
            'index','store','destroy'
        ]]);
        Route::resource('ImportStudent','ImportStudentController',['except'=>[
            'edit','show','update','create'
        ]]);
        Route::get('ImportStudent/download', 'ImportStudentController@download')->name('Overall.download');

        //====小組專區====
        Route::resource('GroupList','GroupListController');
        Route::prefix('GroupList')->group(function (){
            Route::get('plus/{id}','GroupListController@plus_page');
            Route::post('plus/{id}','GroupListController@plus');
            Route::post('destroy_member/{id}','GroupListController@destroy_member');
        });

        //====會議活動====
        Route::resource('meeting','MeetingController');

        //====結算成績====
        Route::prefix('meeting')->group(function(){
            Route::get('/{id}/calc','ScoreController@grades_page');
            Route::post('/search','ScoreController@search');
            Route::post('/score','ScoreController@score');
        });

        //====報告下載====
        Route::prefix('ReportList')->group(function (){
            Route::get('/','ReportListController@index')->name('ReportList.index');
            Route::get('/{id}','ReportListController@show')->name('ReportList.show');
            Route::get('/{id}/download','ReportListController@download')->name('ReportList.download');
            Route::get('/{id}/downloadALL','ReportListController@downloadALL')->name('ReportList.downloadALL');
        });

        //====成績查詢====
        Route::prefix('Transcript')->group(function (){
            Route::get('/','TranscriptController@index')->name('Transcript.index');
            Route::post('/search','TranscriptController@search');
            Route::post('/searchYear','TranscriptController@searchYear');
            Route::post('/searchTeam','TranscriptController@searchTeam');

        });
    });
});

Route::prefix('APS_student')->group(function (){
    // 學生登入
    Route::prefix('login')->group(function (){
        Route::get('/','StuLoginController@index');
        Route::post('/authenticate','StuLoginController@login');
        Route::get('/logout','StuLoginController@logout');
    });

    Route::group(['middleware' => 'auth.student'], function() {
        //====首頁====
        Route::resource('/','StuIndexController',['only'=>[
            'index'
        ]]);
        Route::resource('/','StuIndexController',['except'=>[
            'create','edit','show','store','update','destroy'
        ]]);

        //====小組專區====
        Route::resource('GroupList','StuGroupListController',['only'=>[
            'index','edit','update'
        ]]);
        Route::resource('GroupList','StuGroupListController',['except'=>[
            'create','show','store','destroy'
        ]]);

        //====會議活動====
        Route::prefix('meeting')->group(function (){
            Route::get('/','StuMeetingController@index')->name('StuMeeting.index');
            Route::get('/{id}','StuMeetingController@show')->name('StuMeeting.show');
            Route::get('/report/{id}','StuMeetingController@report')->name('StuMeeting.report');
            Route::post('/report/{id}/upload','StuMeetingController@upload')->name('StuMeeting.upload');
            Route::post('/report/{id}/edit','StuMeetingController@report_edit')->name('StuMeeting.report_edit');
            Route::get('/report/{id}/download','StuMeetingController@download')->name('StuMeeting.download');
            Route::get('score/{id}','StuMeetingController@scoring_page')->name('StuMeeting.scoring_page');
            Route::post('score','StuMeetingController@score');
            Route::post('scoring_member','StuMeetingController@scoring_member');
            Route::post('edit_member','StuMeetingController@edit_member');
            Route::post('scoring_stu','StuMeetingController@scoring_stu');
            Route::post('edit_stu','StuMeetingController@edit_stu');
        });

        //====成績查詢====
        Route::prefix('Transcript')->group(function (){
            Route::get('/','TranscriptController@StuTranscript_index')->name('StuTranscript.index');
            Route::post('/stu_search','TranscriptController@StuTranscript_search');
            Route::post('/searchYearStu','TranscriptController@searchYearStu');
            Route::post('/searchTeam','TranscriptController@searchTeam');

        });

        //====修改密碼====
        Route::resource('ResetPwd','ResetPasswordController',['only'=>[
            'index','update'
        ]]);
        Route::resource('ResetPwd','ResetPasswordController',['except'=>[
            'create','show','store','destroy','edit'
        ]]);
    });

});
