<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AttachmentCommitteePost extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attachment_committee_post', function (Blueprint $table) {
            $table->unsignedBigInteger('attachment_id')->index();
            $table->foreign('attachment_id')->references('id')->on('attachments')->onDelete('cascade');
            $table->unsignedBigInteger('committee_post_id')->index();
            $table->foreign('committee_post_id')->references('id')->on('committee_posts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attachment_committee_post');
    }
}
