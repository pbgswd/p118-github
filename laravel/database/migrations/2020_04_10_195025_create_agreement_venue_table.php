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
        Schema::create('agreement_venue', function (Blueprint $table) {
            $table->unsignedBigInteger('agreement_id')->index();
            $table->foreign('agreement_id')->references('id')->on('agreements')->onDelete('cascade');
            $table->unsignedBigInteger('venue_id')->index();
            $table->foreign('venue_id')->references('id')->on('venues')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agreement_venue');
    }
};
