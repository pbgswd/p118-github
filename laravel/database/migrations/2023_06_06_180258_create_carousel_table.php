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
    public function up()
    {
        Schema::create('carousels', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('caption');
            $table->string('caption2');
            $table->string('link');
            $table->string('color');
            $table->string('button');
            $table->string('align');
            $table->string('credit');
            $table->tinyInteger('live');
            $table->string('order');

            $table->string('image_2000');
            $table->string('file_2000');
            $table->string('image_1400');
            $table->string('file_1400');
            $table->string('image_800');
            $table->string('file_800');
            $table->string('image_600');
            $table->string('file_600');
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
        Schema::dropIfExists('carousel');
    }
};
