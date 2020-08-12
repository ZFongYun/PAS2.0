<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentScore extends Model
{
    use SoftDeletes;
    protected $table = 'student_score';  //指定資料表

    protected $fillable = [
        'student_id','meeting_id','score','bonus','total','count'  //欄位
    ];

    public function student(){
        return $this->belongsTo('App\Models\Student','student_id');
    }

    public function meeting(){
        return $this->belongsTo('App\Models\Meeting','meeting_id');
    }
}
