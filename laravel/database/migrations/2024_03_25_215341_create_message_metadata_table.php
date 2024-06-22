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
        Schema::create('message_metadata', function (Blueprint $table) {
            $table->id();
            $table->integer('message_id')->references('id')->on('messages');
            $table->integer('source_id')->nullable();
            $table->string('source_slug')->nullable();
            $table->string('source_type')->nullable();
            $table->string('source_type_name')->nullable();
            $table->string('source_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('message_metadata');
    }
};
