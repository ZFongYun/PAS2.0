<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangePointColumnToStudentScoringTeamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('student_scoring_team', function (Blueprint $table) {
            DB::statement('ALTER TABLE student_scoring_team MODIFY COLUMN point char (3)');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('student_scoring_team', function (Blueprint $table) {
            DB::statement('ALTER TABLE student_scoring_team MODIFY COLUMN point char (2)');
        });
    }
}
