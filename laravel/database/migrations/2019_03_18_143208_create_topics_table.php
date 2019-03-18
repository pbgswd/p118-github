<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('topics', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->string('safe_name')->unique();
            $table->string('description');
            $table->string('content');
            $table->string('image');
            $table->string('scope');
            $table->enum('live',['yes','no']);
            $table->integer('sort_order')->unsigned();
            $table->enum('in_menu',['yes','no']);
            $table->enum('topic_type',['page','entry']);
            $table->enum('allow_comments',['yes','no']);
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
        Schema::dropIfExists('topics');
    }
}
