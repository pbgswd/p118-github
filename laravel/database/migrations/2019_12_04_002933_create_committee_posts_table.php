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
        Schema::create('committee_posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('committee_id');
            $table->foreign('committee_id')->references('id')->on('committees');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('title')->unique();
            $table->string('slug')->unique();
            $table->text('content');
            $table->boolean('live')->default(1);
            $table->boolean('sticky')->default(0);
            $table->boolean('allow_comments')->default(1);
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
        Schema::dropIfExists('committee_posts');
    }
};
