<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudnetScoringPeerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('studnet_scoring_peer', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('meeting_id');
            $table->foreign('meeting_id')->references('id')->on('meeting');
            //評分人員
            $table->unsignedBigInteger('student_id');
            $table->foreign('student_id')->references('id')->on('student');
            //評分組別
            $table->unsignedBigInteger('team_id');
            $table->foreign('team_id')->references('id')->on('team');
            //評分職務
            $table->char('position', '1');
            $table->char('EV','3');
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
        Schema::dropIfExists('studnet_scoring_peer');
    }
}
