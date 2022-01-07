<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TeamMember extends Model
{
    use SoftDeletes;
    protected $table = 'team_member';  //指定資料表

    protected $fillable = [
        'student_id','team_id','role','position'  //欄位
    ];

    public function student()
    {
        return $this->belongsTo('App\Models\Student');
    }

    public function team()
    {
        return $this->belongsTo('App\Models\Team');
    }
}
