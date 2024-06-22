<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migration.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('committee_post_comments', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('committee_id');
            $table->foreign('committee_id')->references('id')->on('committees');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('post_id');
            $table->foreign('post_id')->references('id')->on('committee_posts');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->text('content');
            $table->boolean('live')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migration.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('committee_post_comments');
    }
};
