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
        Schema::create('message_sending', function (Blueprint $table) {
            $table->id();
            $table->integer('message_id')->references('id')->on('messages');
            $table->string('send_priority')->default('normal');
            $table->string('send_status_now')->default('no')->nullable();
            $table->string('send_status_daily')->default('no')->nullable();
            $table->string('send_status_weekly')->default('no')->nullable();
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
        Schema::dropIfExists('message_sending');
    }
};
