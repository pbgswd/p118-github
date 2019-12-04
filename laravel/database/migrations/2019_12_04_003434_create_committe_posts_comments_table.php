<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommittePostsCommentsTable extends Migration
{
    /**
     * Run the migration.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('committe_posts_comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreign('committee_id')->references('id')->on('committees');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('post_id')->references('id')->on('committee_posts');
            $table->string('content');
            $table->boolean('live');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migration.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('committe_posts_comments');
    }
}
