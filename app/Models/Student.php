<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use SoftDeletes;
    protected $table = 'student';  //指定資料表

    protected $fillable = [
        'student_ID','name','class','password'  //欄位
    ];
}
