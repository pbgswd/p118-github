<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdateAgreementAgreementHandlerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('INSERT INTO agreement_agreement_handler (agreement_handler_id, agreement_id)
            SELECT agreement_handler_id, agreement_id
            FROM venues
            JOIN agreement_venue ON venues.id=agreement_venue.venue_id');

        DB::statement('INSERT INTO agreement_agreement_handler (agreement_handler_id, agreement_id)
            SELECT agreement_handler_id, agreement_id
            FROM organizations
            JOIN agreement_organization ON organizations.id=agreement_organization.organization_id');

    }

    /**
    INSERT INTO agreement_agreement_handler (agreement_handler_id, agreement_id)
    SELECT agreement_handler_id, agreement_id
    FROM venues
    JOIN agreement_venue ON venues.id=agreement_venue.venue_id;

    INSERT INTO agreement_agreement_handler (agreement_handler_id, agreement_id)
    SELECT agreement_handler_id, agreement_id
    FROM organizations
    JOIN agreement_organization ON organizations.id=agreement_organization.organization_id;
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
