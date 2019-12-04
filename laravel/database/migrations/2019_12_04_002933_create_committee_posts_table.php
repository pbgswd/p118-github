<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommitteePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('committee_posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreign('committee_id')->references('id')->on('committees');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('title')->unique();
            $table->string('slug')->unique();
            $table->string('content');
            $table->string('access_level')->nullable();
            $table->boolean('live');
            $table->boolean('sticky');
            $table->boolean('allow_comments');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('committee_posts');
    }
}
