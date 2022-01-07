<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentScoringPeer extends Model
{
    use SoftDeletes;
    protected $table = 'student_scoring_peer';  //指定資料表

    protected $fillable = [
        'meeting_id','student_id','peer_id','EV','feedback'  //欄位
    ];
}
