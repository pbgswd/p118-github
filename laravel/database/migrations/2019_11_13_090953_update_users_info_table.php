<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUsersInfoTable extends Migration
{
    /**
     * Run the migration.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users_info', function (Blueprint $table) {
            $table->string('file_name')->nullable()->after('share_phone');
        });
    }

    /**
     * Reverse the migration.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users_info', function (Blueprint $table) {
            $table->dropColumn('file_name');
        });
    }
}
