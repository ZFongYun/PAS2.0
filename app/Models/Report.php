<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Report extends Model
{
    use SoftDeletes;
    protected $table = 'report';  //指定資料表

    protected $fillable = [
        'meeting_id','team_id','file'  //欄位
    ];

    public function meeting(){
        return $this->belongsTo('App\Models\Meeting','meeting_id');
    }

    public function team(){
        return $this->belongsTo('App\Models\Team','team_id');
    }
}
