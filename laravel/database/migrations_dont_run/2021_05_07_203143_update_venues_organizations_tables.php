<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdateVenuesOrganizationsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement(' UPDATE venues JOIN agreement_handlers ON venues.id=agreement_handlers.venue_id
            SET venues.agreement_handler_id=agreement_handlers.id
            WHERE agreement_handlers.venue_id IS NOT NULL');

        DB::statement('UPDATE organizations JOIN agreement_handlers ON organizations.id=agreement_handlers.organization_id
            SET organizations.agreement_handler_id=agreement_handlers.id
            WHERE agreement_handlers.organization_id IS NOT NULL');

    }

    /**
     * UPDATE venues JOIN agreement_handlers ON venues.id=agreement_handlers.venue_id
    SET venues.agreement_handler_id=agreement_handlers.id
    WHERE agreement_handlers.venue_id IS NOT NULL;

    UPDATE organizations JOIN agreement_handlers ON organizations.id=agreement_handlers.organization_id
    SET organizations.agreement_handler_id=agreement_handlers.id
    WHERE agreement_handlers.organization_id IS NOT NULL;
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
