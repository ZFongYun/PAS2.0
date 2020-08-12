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

    public function Team(){
        return $this->belongsTo('App\Models\Team','team_id');
    }

    public function meeting(){
        return $this->belongsTo('App\Models\Meeting','meeting_id');
    }
}
