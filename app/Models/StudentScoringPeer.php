<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentScoringPeer extends Model
{
    use SoftDeletes;
    protected $table = 'student_scoring_peer';  //指定資料表

    protected $fillable = [
        'meeting_id','raters_student_id','object_student_id','point','feedback'  //欄位
    ];

    public function meeting(){
        return $this->belongsTo('App\Models\Meeting','meeting_id');
    }

    public function raters_student(){
        return $this->belongsTo('App\Models\Student','raters_student_id');
    }

    public function object_student(){
        return $this->belongsTo('App\Models\Student','object_student_id');
    }
}
