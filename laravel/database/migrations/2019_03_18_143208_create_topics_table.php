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
        Schema::create('topics', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->string('safe_name')->unique();
            $table->string('description');
            $table->string('content');
            $table->string('image');
            $table->string('scope');
            $table->enum('live', ['yes', 'no']);
            $table->integer('sort_order')->unsigned();
            $table->enum('in_menu', ['yes', 'no']);
            $table->enum('topic_type', ['page', 'entry']);
            $table->enum('allow_comments', ['yes', 'no']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('topics');
    }
};
