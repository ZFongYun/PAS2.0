<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TeacherScoringTeam extends Model
{
    use SoftDeletes;
    protected $table = 'teacher_scoring_team';  //指定資料表

    protected $fillable = [
        'meeting_id','raters_teacher_id','object_team_id','point','feedback'  //欄位
    ];

    public function meeting(){
        return $this->belongsTo('App\Models\Meeting','meeting_id');
    }

    public function teacher(){
        return $this->belongsTo('App\Models\Teacher','raters_teacher_id');
    }

    public function team(){
        return $this->belongsTo('App\Models\Team','object_team_id');
    }


}
