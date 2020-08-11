<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Teacher extends Model
{
    use SoftDeletes;
    protected $table = 'teacher';  //指定資料表

    protected $fillable = [
        'account','password'  //欄位
    ];
}
