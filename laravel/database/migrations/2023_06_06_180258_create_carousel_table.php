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
        Schema::create('carousel', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('link');
            $table->string('description');
            $table->string('color');
            $table->string('align');
            $table->string('button');
            $table->string('credit');
            $table->string('live');
            $table->string('order');
            $table->string('2000_image');
            $table->string('2000_file');
            $table->string('1400_image');
            $table->string('1400_file');
            $table->string('800_image');
            $table->string('800_file');
            $table->string('600_image');
            $table->string('600_file');
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
