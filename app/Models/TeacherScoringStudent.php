<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TeacherScoringStudent extends Model
{
    use SoftDeletes;
    protected $table = 'teacher_scoring_student';  //指定資料表

    protected $fillable = [
        'meeting_id','raters_teacher_id','object_student_id','point','feedback'  //欄位
    ];
}
