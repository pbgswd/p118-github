<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('carousels', function (Blueprint $table) {
            $table->dropColumn('credit');
            $table->string('text_color')->after('align')->nullable();
            $table->string('image_2000')->nullable()->change();
            $table->string('file_2000')->nullable()->change();
            $table->string('image_1400')->nullable()->change();
            $table->string('file_1400')->nullable()->change();
            $table->string('image_800')->nullable()->change();
            $table->string('file_800')->nullable()->change();
            $table->string('image_600')->nullable()->change();
            $table->string('file_600')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('carousels', function (Blueprint $table) {
            $table->string('credit')->after('align')->nullable();
            $table->dropColumn('text_color');
        });
    }
};
