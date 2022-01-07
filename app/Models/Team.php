<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends Model
{
    use SoftDeletes;
    protected $table = 'team';  //指定資料表

    protected $fillable = [
        'name','year','semester','content','status'  //欄位
    ];
}
