<?php

namespace App\Imports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Hash;

class ImportContacts implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if(!Student::where('student_ID', '=', $row[1])->exists()) {
            return new Student([
                'class' => @$row[0],
                'student_ID' => @$row[1],
                'name' => @$row[2],
                'password' => HASH::make(@$row[3])
            ]);
        }

    }
}
