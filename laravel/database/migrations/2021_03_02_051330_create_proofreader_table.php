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
        Schema::create('proofreader', function (Blueprint $table) {
            $table->id();

            $table->string('admin_link')->unique();
            $table->string('pub_link')->unique();
            $table->string('title')->unique();
            $table->string('content_type');
            $table->string('content_title');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->dateTime('proofread_at')->nullable();
            $table->dateTime('content_updated_at');
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
        Schema::dropIfExists('proofreader');
    }
};
