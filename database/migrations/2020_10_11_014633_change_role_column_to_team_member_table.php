<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeRoleColumnToTeamMemberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('team_member', function (Blueprint $table) {
            DB::statement('ALTER TABLE team_member MODIFY COLUMN role char (1)');
            DB::statement('ALTER TABLE team_member MODIFY COLUMN position char (1)');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('team_member', function (Blueprint $table) {
            DB::statement('ALTER TABLE team_member MODIFY COLUMN role varchar (2)');
            DB::statement('ALTER TABLE team_member MODIFY COLUMN position varchar (2)');
        });
    }
}
