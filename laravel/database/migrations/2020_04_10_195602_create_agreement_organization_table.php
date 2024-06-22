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
        Schema::create('agreement_organization', function (Blueprint $table) {
            $table->unsignedBigInteger('agreement_id')->index();
            $table->foreign('agreement_id')->references('id')->on('agreements')->onDelete('cascade');
            $table->unsignedBigInteger('organization_id')->index();
            $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agreement_organization');
    }
};
