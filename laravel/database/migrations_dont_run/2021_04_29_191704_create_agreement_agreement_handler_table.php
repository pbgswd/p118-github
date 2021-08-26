<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgreementAgreementHandlerTable extends Migration
{
    /**
     * Run the migration.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agreement_agreement_handler', function (Blueprint $table) {

            $table->unsignedBigInteger('agreement_id');
            $table->foreign('agreement_id')->references('id')->on('agreements');
            $table->unsignedBigInteger('agreement_handler_id');
            $table->foreign('agreement_handler_id')->references('id')->on('agreement_handlers');
        });
    }


    /**
     * CREATE TABLE `agreement_agreement_handler` (
    `agreement_id` int UNSIGNED NOT NULL,
    `agreement_handler_id` int UNSIGNED NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
     */


    /**
     * Reverse the migration.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agreement_agreement_handler');
    }
}
