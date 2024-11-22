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
        //todo add count to messages row
        Schema::table('messages', function (Blueprint $table) {
            $table->integer('count')->after('user_id')->nullable();
        });

        //todo
        // remove messagemetadata
        // messagesending
        // drop most tables from email queue
        // create message log table
        Schema::dropIfExists('message_metatdata'); //delete model
        Schema::dropIfExists('message_sending'); //delete model
        Schema::dropIfExists('message_frequency_preferences'); //delete model
        Schema::dropIfExists('email_queue'); //delete model

        //todo alter table messages, add source_url=null, count=null(not_sent,send,sent), sent_state=not_sent -- 3 cols total

        Schema::table('messages', function (Blueprint $table) {
            $table->string('source_url')->after('id')->nullable();
            $table->string('section')->after('source_url')->nullable();//section (model, topic, committee)
            $table->string('category')->after('section')->nullable(); //category (what kind of model, topic, or committee)
            $table->integer('count')->after('user_id')->nullable();
            $table->string('state')->after('count')->default('not_sent')->nullable();
        });


        Schema::create('email_queue', function (Blueprint $table) {
            $table->id();
            $table->integer('message_id')->references('id')->on('messages');
            $table->integer('user_id')->references('id')->on('users');
            $table->index(['section', 'category', 'message_id', 'user_id']);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //todo remove count from messages
        // probably not going back to old schema
    }
};
