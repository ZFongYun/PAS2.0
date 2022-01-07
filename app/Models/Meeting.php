<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Meeting extends Model
{
    use SoftDeletes;
    protected $table = 'meeting';  //指定資料表

    protected $fillable = [
        'name','year','semester','content','meeting_date','meeting_start','meeting_end','upload_date','upload_time'  //欄位
    ];

}
