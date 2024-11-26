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

        Schema::dropIfExists('message_metatdata'); //delete model
        Schema::dropIfExists('message_sending'); //delete model
        Schema::dropIfExists('message_frequency_preferences'); //delete model
        Schema::dropIfExists('email_queue'); //delete model

        Schema::table('messages', function (Blueprint $table) {
            $table->string('source_url')->after('id')->nullable();
            $table->string('section')->after('source_url')->nullable();//section (model, topic, committee)
            $table->string('category')->after('section')->nullable(); //category (what kind of model, topic, or committee)
            $table->string('subject')->after('category')->index()->change();
            $table->text('content')->after('slug')->fulltext()->change();
            $table->integer('count')->after('user_id')->default(0);
            $table->string('state')->after('count')->default('not_sent')->index();
        });

        Schema::create('email_queue', function (Blueprint $table) {
            $table->id();
            $table->integer('message_id')->references('id')->on('messages');
            $table->integer('user_id')->references('id')->on('users');
            $table->index(['message_id', 'user_id']);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //todo not going back to old schema. Re install db for now if needed.
    }
};
