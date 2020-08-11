<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Meeting extends Model
{
    use SoftDeletes;
    protected $table = 'meeting';  //指定資料表

    protected $fillable = [
        'name','meeting_date','meeting_start','meeting_end','content','upload_date','upload_time','report_team','PA','TS','team_limit','team_bonus','member_limit','member_bonus'  //欄位
    ];
}
