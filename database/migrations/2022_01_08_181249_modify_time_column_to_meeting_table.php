<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ModifyTimeColumnToMeetingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('meeting', function (Blueprint $table) {
            DB::statement('ALTER TABLE meeting MODIFY COLUMN meeting_start time ');
            DB::statement('ALTER TABLE meeting MODIFY COLUMN meeting_end time ');
            DB::statement('ALTER TABLE meeting MODIFY COLUMN upload_time time ');
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
            DB::statement('ALTER TABLE meeting MODIFY COLUMN meeting_start timestamp ');
            DB::statement('ALTER TABLE meeting MODIFY COLUMN meeting_end timestamp ');
            DB::statement('ALTER TABLE meeting MODIFY COLUMN upload_time timestamp ');
        });
    }
}
