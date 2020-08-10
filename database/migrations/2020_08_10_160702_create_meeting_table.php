<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeetingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meeting', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name','50');
            $table->date('meeting_date');
            $table->timestamp('meeting_start');
            $table->timestamp('meeting_end');
            $table->string('content','1024');
            $table->date('upload_date');
            $table->timestamp('upload_time');
            $table->string('report_team','1024');
            $table->char('PA','2');
            $table->char('TS','2');
            $table->char('team_limit','2');
            $table->char('team_bonus','2');
            $table->char('member_limit','2');
            $table->char('member_bonus','2');
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
        Schema::dropIfExists('meeting');
    }
}
