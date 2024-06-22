<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE topics CHANGE scope access_level VARCHAR (255) NOT NULL DEFAULT 'members'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE topics CHANGE access_level scope in_menu VARCHAR (255) NOT NULL DEFAULT 'members'");
    }
};
