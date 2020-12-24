<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangePAPSColumnToMeetingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('meeting', function (Blueprint $table) {
            DB::statement('ALTER TABLE meeting MODIFY COLUMN PA char (3)');
            DB::statement('ALTER TABLE meeting MODIFY COLUMN TS char (3)');
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
            DB::statement('ALTER TABLE meeting MODIFY COLUMN PA char (2)');
            DB::statement('ALTER TABLE meeting MODIFY COLUMN TS char (2)');
        });
    }
}
