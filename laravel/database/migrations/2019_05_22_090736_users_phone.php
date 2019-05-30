<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UsersPhone extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phone_numbers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unisgnedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('phone_number', 20);
            $table->string('label', 20)->nullable();
            $table->boolean('primary')->default(false);
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
        Schema::dropIfExists('phone_numbers');
    }
}
