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
        Schema::create('pages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->unique();
            $table->string('slug')->unique();
            $table->string('description')->nullable();
            $table->string('content');
            $table->string('image')->nullable();
            $table->string('access_level')->nullable();
            $table->boolean('live');
            $table->integer('sort_order')->unsigned()->nullable();
            $table->boolean('in_menu');
            $table->boolean('allow_comments');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
