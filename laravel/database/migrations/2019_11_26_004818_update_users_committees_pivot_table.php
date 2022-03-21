<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migration.
     *
     * @return void
     */
    public function up()
    {
        // add role
        Schema::table('users_committees_pivot', function (Blueprint $table) {
            $table->string('role')->after('user_id');
        });
    }

    /**
     * Reverse the migration.
     *
     * @return void
     */
    public function down()
    {
        //drop role
        Schema::table('users_committees_pivot', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};
