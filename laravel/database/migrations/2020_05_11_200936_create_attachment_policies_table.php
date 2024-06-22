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
        Schema::create('attachment_policies', function (Blueprint $table) {
            $table->unsignedBigInteger('attachment_id')->index();
            $table->foreign('attachment_id')->references('id')->on('attachments')->onDelete('cascade');
            $table->unsignedBigInteger('policy_id')->index();
            $table->foreign('policy_id')->references('id')->on('policies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attachment_policies');
    }
};
