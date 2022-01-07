<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MeetingTeam extends Model
{
    use SoftDeletes;
    protected $table = 'meeting_team';  //指定資料表

    protected $fillable = [
        'meeting_id','team_id','calc_status'  //欄位
    ];
}
