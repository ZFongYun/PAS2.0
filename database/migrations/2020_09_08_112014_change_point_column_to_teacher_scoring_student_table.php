<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangePointColumnToTeacherScoringStudentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('teacher_scoring_student', function (Blueprint $table) {
            DB::statement('ALTER TABLE teacher_scoring_student MODIFY COLUMN point char (3)');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('teacher_scoring_student', function (Blueprint $table) {
            DB::statement('ALTER TABLE teacher_scoring_student MODIFY COLUMN point char (2)');
        });
    }
}
