<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('message_categories', function (Blueprint $table) {
            $table->id();
            $table->integer('message_id')->references('id')->on('messages')->index();
            $table->string('type');
            $table->string('name');
            $table->timestamps();
        });

       Schema::table('users', function (Blueprint $table) {
           DB::statement('UPDATE users set `is_banned` = 0 where `is_banned` IS NULL');
           $table->tinyInteger('is_banned')->default(0)->index()->change();
       });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('message_categories');

        Schema::table('messages', function (Blueprint $table) {
            $table->string('section')->after('source_url')->nullable();
            $table->string('category')->after('section')->nullable();
        });
    }
};
