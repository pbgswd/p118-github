<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement('ALTER TABLE topics CHANGE live live TINYINT UNSIGNED NOT NULL DEFAULT 0');
        DB::statement('ALTER TABLE topics CHANGE in_menu in_menu TINYINT UNSIGNED NOT NULL DEFAULT 0');
        DB::statement('ALTER TABLE topics CHANGE allow_comments allow_comments TINYINT UNSIGNED NOT NULL DEFAULT 0');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('topics', function ($table) {
            $table->dropColumn('live');
            $table->enum('role', ['yes', 'no'])->default('no')->after('scope');

            $table->dropColumn('in_menu');
            $table->enum('in_menu', ['yes', 'no'])->default('no')->after('sort_order');

            $table->dropColumn('allow_comments');
            $table->enum('allow_comments', ['yes', 'no'])->default('no')->after('in_menu');
        });
    }
};
