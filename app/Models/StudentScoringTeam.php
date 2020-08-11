<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentScoringTeam extends Model
{
    use SoftDeletes;
    protected $table = 'student_scoring_team';  //指定資料表

    protected $fillable = [
        'meeting_id','raters_student_id','object_team_id','point','feedback'  //欄位
    ];
}
