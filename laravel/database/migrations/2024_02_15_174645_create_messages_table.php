<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {

            $table->id();

            /*            $table->integer('source_id')->nullable();
                        $table->string('source_slug')->nullable();
                        $table->string('source_type')->nullable();
                        $table->string('source_type_name')->nullable();
                        $table->string('source_url')->nullable();*/

            $table->string('subject')->unique();
            $table->string('slug')->unique()->nullable();
            $table->text('content');
            $table->integer('user_id')->references('id')->on('users');

            /*            $table->string('send_priority');
                        $table->string('send_status_now')->default('no')->nullable();
                        $table->string('send_status_daily')->default('no')->nullable();
                        $table->string('send_status_weekly')->default('no')->nullable();*/
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
