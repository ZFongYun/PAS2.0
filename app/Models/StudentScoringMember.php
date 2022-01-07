<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentScoringMember extends Model
{
    use SoftDeletes;
    protected $table = 'studnet_scoring_member';  //指定資料表

    protected $fillable = [
        'meeting_id','student_id','member_id','CV','feedback'  //欄位
    ];
}
