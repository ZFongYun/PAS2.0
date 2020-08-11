<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeacherScoringStudentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teacher_scoring_student', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('meeting_id')->unsigned();
            $table->foreign('meeting_id')->references('id')->on('meeting');

            $table->integer('raters_teacher_id')->unsigned();
            $table->foreign('raters_teacher_id')->references('id')->on('teacher');

            $table->integer('object_student_id')->unsigned();
            $table->foreign('object_student_id')->references('id')->on('student');

            $table->char('point','2');
            $table->string('feedback','1024');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teacher_scoring_student');
    }
}
