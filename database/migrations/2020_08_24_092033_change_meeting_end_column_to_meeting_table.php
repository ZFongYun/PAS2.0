<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeMeetingEndColumnToMeetingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('meeting', function (Blueprint $table) {
            $table->date('meeting_start')->nullable(false)->change();
            $table->date('meeting_end')->nullable(false)->change();
            $table->date('upload_time')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('meeting', function (Blueprint $table) {
            $table->date('meeting_start')->nullable()->change();
            $table->date('meeting_end')->nullable()->change();
            $table->date('upload_time')->nullable()->change();
        });
    }
}
