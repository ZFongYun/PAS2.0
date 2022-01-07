<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MeetingReport extends Model
{
    use SoftDeletes;
    protected $table = 'meeting_report';  //指定資料表

    protected $fillable = [
        'meeting_id','team_id','file_name'  //欄位
    ];

    public function meeting()
    {
        return $this->belongsTo('App\Models\Meeting');
    }

    public function team()
    {
        return $this->belongsTo('App\Models\Team');
    }
}
