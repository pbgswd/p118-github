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
        Schema::create('faqs_data', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('faq_id');
            $table->foreign('faq_id')->references('id')->on('faqs');
            $table->string('question');
            $table->text('answer');
            $table->integer('sort_order');
            $table->string('access_level')->default('members');
            $table->boolean('live')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faqs_data');
    }
};
