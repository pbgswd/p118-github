<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAgreementHandlerIdToOrganizationsAndVenues extends Migration
{
    /**
     * Run the migration.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('organizations', function (Blueprint $table) {
            $table->unsignedBigInteger('agreement_handler_id')->after('access_level')->nullable();
            $table->foreign('agreement_handler_id')->references('id')->on('agreement_handlers');
        });

        Schema::table('venues', function (Blueprint $table) {
            $table->unsignedBigInteger('agreement_handler_id')->after('access_level')->nullable();
            $table->foreign('agreement_handler_id')->references('id')->on('agreement_handlers');
        });

        /**
         * ALTER TABLE `organizations` ADD `agreement_handler_id` INT UNSIGNED NULL AFTER `access_level`;
         * ALTER TABLE `venues` ADD `agreement_handler_id` INT UNSIGNED NULL AFTER `access_level`;
         */

    }

    /**
     * Reverse the migration.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('organizations', function (Blueprint $table) {

            $table->dropColumn('agreement_handler_id');
        });

        Schema::table('venues', function (Blueprint $table) {
            $table->dropColumn('agreement_handler_id');
        });
    }
}
