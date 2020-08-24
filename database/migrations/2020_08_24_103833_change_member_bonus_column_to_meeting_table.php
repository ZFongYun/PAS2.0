<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeMemberBonusColumnToMeetingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('meeting', function (Blueprint $table) {
            DB::statement('ALTER TABLE meeting MODIFY COLUMN team_bonus char (5)');
            DB::statement('ALTER TABLE meeting MODIFY COLUMN member_bonus char (5)');
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
            DB::statement('ALTER TABLE meeting MODIFY COLUMN team_bonus char (2)');
            DB::statement('ALTER TABLE meeting MODIFY COLUMN member_bonus char (2)');
        });
    }
}
