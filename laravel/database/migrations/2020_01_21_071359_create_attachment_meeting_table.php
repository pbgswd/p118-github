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
        Schema::create('attachment_meeting', function (Blueprint $table) {
            $table->unsignedBigInteger('attachment_id')->index();
            $table->foreign('attachment_id')->references('id')->on('attachments')->onDelete('cascade');
            $table->unsignedBigInteger('meeting_id')->index();
            $table->foreign('meeting_id')->references('id')->on('meetings')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attachment_meeting');
    }
};
