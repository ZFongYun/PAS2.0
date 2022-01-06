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
            $table->char('year','3');
            $table->char('semester','1');
            $table->string('content','512');
            $table->date('meeting_date');
            $table->timestamp('meeting_start');
            $table->timestamp('meeting_end');
            $table->date('upload_date');
            $table->timestamp('upload_time');
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
