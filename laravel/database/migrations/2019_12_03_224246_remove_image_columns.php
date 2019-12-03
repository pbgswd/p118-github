<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveImageColumns extends Migration
{
    /**
     * Run the migration.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('topics', function (Blueprint $table) {
            $table->dropColumn('image');
        });
        Schema::table('venues', function (Blueprint $table) {
            $table->dropColumn('image');
        });

        Schema::table('pages', function (Blueprint $table) {
        $table->dropColumn('image');
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('image');
        });
    }

    /**
     * Reverse the migration.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('topics', function (Blueprint $table) {
            $table->string('image')->nullable()->after('description');
        });
        Schema::table('venues', function (Blueprint $table) {
            $table->string('image')->nullable()->after('url');
        });

        Schema::table('pages', function (Blueprint $table) {
        $table->string('image')->nullable()->after('content');
    });
        Schema::table('posts', function (Blueprint $table) {
            $table->string('image')->nullable()->after('content');
        });
    }
}
