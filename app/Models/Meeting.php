<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Meeting extends Model
{
    use SoftDeletes;
    protected $table = 'meeting';  //指定資料表

    protected $fillable = [
        'name','meeting_date','meeting_start','meeting_end','content','upload_date','upload_time','report_team','PA','TS','team_limit','team_bonus','member_limit','member_bonus'  //欄位
    ];

    public function report(){
        return $this->hasMany('App\Models\Report');
    }

    public function student_score(){
        return $this->hasMany('App\Models\StudentScore');
    }

    public function student_scoring_peer(){
        return $this->hasMany('App\Models\StudentScoringPeer');
    }

    public function teacher_scoring_student(){
        return $this->hasMany('App\Models\TeacherScoringStudent');
    }

    public function team_score(){
        return $this->hasMany('App\Models\TeamScore');
    }

    public function student_scoring_team(){
        return $this->hasMany('App\Models\StudentScoringTeam');
    }

    public function teacher_scoring_team(){
        return $this->hasMany('App\Models\TeacherScoringTeam');
    }
}
