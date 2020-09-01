<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Teacher extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;
    protected $table = 'teacher';  //指定資料表

    protected $fillable = [
        'account','password'  //欄位
    ];

    public function teacher_scoring_student(){
        return $this->hasMany('App\Models\TeacherScoringStudent');
    }

    public function teacher_scoring_team(){
        return $this->hasMany('App\Models\TeacherScoringTeam');
    }
}
