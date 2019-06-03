<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddUserToPages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE pages CHANGE content content TEXT NULL");

        DB::beginTransaction();

        Schema::table('pages', function (Blueprint $table) {
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
        DB::statement("ALTER TABLE pages CHANGE content content varchar( 255 )  NULL");

        DB::beginTransaction();

        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
        DB::commit();
    }
}
