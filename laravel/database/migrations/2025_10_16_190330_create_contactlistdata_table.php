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
        Schema::create('contactlistdata', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('addr1')->nullable();
            $table->string('addr2')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('country')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('website')->nullable();
            $table->string('email')->nullable();
            $table->string('contact')->nullable();
            $table->string('phone')->nullable();
            $table->text('notes')->nullable();
            $table->string('access_level')->default('public');
            $table->boolean('live')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contactlistdata');
    }
};
