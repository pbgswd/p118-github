<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgreementHandlersTable extends Migration
{
    /**
     * Run the migration.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agreement_handlers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('venue_id')->default(null)->nullable();
            $table->unsignedbigInteger('organization_id')->default(null)->nullable();
            $table->timestamps();
        });
    }

    /**
     *
    CREATE TABLE `agreement_handlers` (
    `id` int UNSIGNED NOT NULL,
    `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ALTER TABLE `agreement_handlers`
    ADD PRIMARY KEY (`id`);
     *
    ALTER TABLE `agreement_handlers`
    MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

    ALTER TABLE agreement_handlers
    ADD COLUMN `venue_id` bigint UNSIGNED,
    ADD COLUMN `organization_id` bigint UNSIGNED;

     */

    /**
     * Reverse the migration.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agreement_handlers');
    }
}
