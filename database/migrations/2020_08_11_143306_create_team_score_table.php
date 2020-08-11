<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamScoreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('team_score', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('team_id')->unsigned();
            $table->foreign('team_id')->references('id')->on('team');
            $table->integer('meeting_id')->unsigned();
            $table->foreign('meeting_id')->references('id')->on('meeting');
            $table->char('score','2');
            $table->char('bonus','4');
            $table->char('total','2');
            $table->char('count','2');
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
        Schema::dropIfExists('team_score');
    }
}
