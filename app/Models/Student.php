<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Student extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;
    protected $table = 'student';  //指定資料表

    protected $fillable = [
        'student_ID','name','class','password' //欄位
    ];

    public function score()
    {
        return $this->hasMany('App\Models\StudentScore','student_id');
    }

    public function team()
    {
        return $this->hasMany('App\Models\TeamMember','member_id');
    }
}
