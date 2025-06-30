<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement('ALTER TABLE pages CHANGE content content TEXT NULL');

        DB::beginTransaction();

        Schema::table('pages', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->after('id')->default(1); // assuming user 1 exists if any users exist.
            $table->foreign('user_id')->references('id')->on('users');
        });
        DB::commit();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('ALTER TABLE pages CHANGE content content varchar( 255 )  NULL');

        DB::beginTransaction();

        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
        DB::commit();
    }
};
