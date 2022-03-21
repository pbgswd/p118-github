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
    public function up()
    {
        Schema::table('organizations', function (Blueprint $table) {
            $table->string('url')->nullable()->change();
            $table->string('access_level')->default(\App\Constants\AccessLevelConstants::MEMBERS)->change();
            $table->foreign('access_level')->references('access_level')->on('access_level_constants'); //disabled to run migration. not needed.
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('organizations', function (Blueprint $table) {
            $table->string('url')->nullable(false)->change();
        });
    }
};
