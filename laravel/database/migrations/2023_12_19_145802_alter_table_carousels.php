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
        Schema::table('carousels', function (Blueprint $table) {
            $table->dropColumn('credit');
            $table->string('text_color')->after('align')->nullable();
            $table->string('text_outline_color')->after('text_color')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('carousels', function (Blueprint $table) {
            $table->string('credit')->after('align')->nullable();
            $table->dropColumn('text_color');
            $table->dropColumn('link');
            $table->dropColumn('button');
            $table->dropColumn('color');

        });
    }
};
