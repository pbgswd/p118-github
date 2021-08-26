<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class PopulateAgreementHandlersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('INSERT INTO agreement_handlers (organization_id)
            SELECT DISTINCT organization_id FROM agreement_organization');

        DB::statement('INSERT INTO agreement_handlers (venue_id)
            SELECT DISTINCT venue_id FROM agreement_venue');

    }

/**

INSERT INTO agreement_handlers (organization_id)
SELECT DISTINCT organization_id FROM agreement_organization;

INSERT INTO agreement_handlers (venue_id)
SELECT DISTINCT venue_id FROM agreement_venue;
**/


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
