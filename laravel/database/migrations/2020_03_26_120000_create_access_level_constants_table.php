<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migration.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('access_level_constants', static function (Blueprint $table) {
            $table->string('access_level')->unique();
            $table->string('display');
        });

        DB::insert(
            "INSERT INTO access_level_constants (access_level, display)
            SELECT access_level, display
            FROM (
                SELECT
                    'public' AS access_level,
                    'Public' AS display
                FROM dual
                UNION
                SELECT
                    'members' AS access_level,
                    'Members' AS display
                FROM dual
            ) levels
            WHERE NOT EXISTS (
                SELECT 1
                FROM access_level_constants alc
                WHERE levels.access_level = alc.access_level
            )");

        Schema::table('agreements', static function (Blueprint $table) {
            $table->foreign('access_level')->references('access_level')->on('access_level_constants');
        });
        Schema::table('bylaws', static function (Blueprint $table) {
            $table->foreign('access_level')->references('access_level')->on('access_level_constants');
        });
        Schema::table('committees', static function (Blueprint $table) {
            $table->foreign('access_level')->references('access_level')->on('access_level_constants');
        });
        Schema::table('organizations', static function (Blueprint $table) {
            $table->foreign('access_level')->references('access_level')->on('access_level_constants');
        });
        Schema::table('pages', static function (Blueprint $table) {
            $table->foreign('access_level')->references('access_level')->on('access_level_constants');
        });
        Schema::table('posts', static function (Blueprint $table) {
            $table->foreign('access_level')->references('access_level')->on('access_level_constants');
        });
        Schema::table('topics', static function (Blueprint $table) {
            $table->foreign('access_level')->references('access_level')->on('access_level_constants');
        });
        Schema::table('venues', static function (Blueprint $table) {
            $table->foreign('access_level')->references('access_level')->on('access_level_constants');
        });
    }

    /**
     * Reverse the migration.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('access_level_constants');
    }
};
