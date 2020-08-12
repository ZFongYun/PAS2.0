<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends Model
{
    use SoftDeletes;
    protected $table = 'team';  //指定資料表

    protected $fillable = [
        'name'  //欄位
    ];

    public function report(){
        return $this->hasMany('App\Models\Report');
    }

    public function team_member(){
        return $this->hasMany('App\Models\TeamMember');
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
