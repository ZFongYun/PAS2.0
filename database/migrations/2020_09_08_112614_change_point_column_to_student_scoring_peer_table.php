<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangePointColumnToStudentScoringPeerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('student_scoring_peer', function (Blueprint $table) {
            DB::statement('ALTER TABLE student_scoring_peer MODIFY COLUMN point char (3)');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('student_scoring_peer', function (Blueprint $table) {
            DB::statement('ALTER TABLE student_scoring_peer MODIFY COLUMN point char (2)');
        });
    }
}
