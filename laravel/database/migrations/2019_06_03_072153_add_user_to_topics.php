<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddUserToTopics extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::beginTransaction();

        Schema::table('topics', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->after('id')->default(1); //assuming user 1 exists if any users exist.
            $table->foreign('user_id')->references('id')->on('users');
        });

        DB::commit();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::beginTransaction();

        Schema::table('topics', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });

        DB::commit();
    }
}
