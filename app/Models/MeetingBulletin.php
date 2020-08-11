<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MeetingBulletin extends Model
{
    use SoftDeletes;
    protected $table = 'meeting_bulletin';  //指定資料表

    protected $fillable = [
        'title','content'  //欄位
    ];
}
