<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('attachments', function (Blueprint $table) {
            $table->string('access_level')->default(\App\Constants\AccessLevelConstants::MEMBERS)->after('file');
            $table->foreign('access_level')->references('access_level')->on('access_level_constants');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('attachments', function (Blueprint $table) {
            $table->dropColumn('access_level');
        });
    }
};
