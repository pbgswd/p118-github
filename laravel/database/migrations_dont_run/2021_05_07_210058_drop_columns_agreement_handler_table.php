<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DropColumnsAgreementHandlerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE agreement_handlers
            DROP COLUMN `venue_id`,
            DROP COLUMN `organization_id`');
    }

    /**
    ALTER TABLE agreement_handlers
    DROP COLUMN `venue_id`,
    DROP COLUMN `organization_id`;
     */

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
