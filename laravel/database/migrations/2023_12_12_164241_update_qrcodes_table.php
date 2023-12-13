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
        Schema::table('qrcodes', function (Blueprint $table) {
            $table->dropColumn('url');
            $table->string('qrtype')->after('user_id');
            $table->string('qrdata')->after('qrtype');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::create('qrcodes', function (Blueprint $table) {
            $table->dropColumn('qrtype');
            $table->dropColumn('qrdata');
        });
    }
};
