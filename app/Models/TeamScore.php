<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TeamScore extends Model
{
    use SoftDeletes;
    protected $table = 'team_score';  //指定資料表

    protected $fillable = [
        'team_id','meeting_id','score','bonus','total','count'  //欄位
    ];
}
