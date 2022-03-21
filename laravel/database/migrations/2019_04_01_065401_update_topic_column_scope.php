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
    public function up()
    {
        DB::statement("ALTER TABLE topics CHANGE scope access_level VARCHAR (255) NOT NULL DEFAULT 'members'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE topics CHANGE access_level scope in_menu VARCHAR (255) NOT NULL DEFAULT 'members'");
    }
};
