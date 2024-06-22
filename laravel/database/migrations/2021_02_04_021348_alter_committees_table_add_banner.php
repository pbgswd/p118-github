<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('committees', function (Blueprint $table) {
            $table->string('file_name')->after('description')->nullable();
            $table->dropForeign(['access_level']);
            $table->dropColumn('access_level');
            $table->dropColumn('in_menu');
            $table->dropColumn('sort_order');
            $table->string('image')->after('file_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('committees', function (Blueprint $table) {
            $table->tinyInteger('in_menu')->after('description')->nullable();
            $table->integer('sort_order')->after('description')->nullable();
            $table->string('access_level')->after('description')->nullable();
            $table->dropColumn('image');
            $table->dropColumn('file_name');
        });
    }
};
