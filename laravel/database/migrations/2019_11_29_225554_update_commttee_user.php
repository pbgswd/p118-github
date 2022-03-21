<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // add role
        Schema::table('users_committees_pivot', function (Blueprint $table) {
            // rename to committee_user

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::rename('users_committees_pivot', 'committee_user');
    }

    /**
     * Reverse the migration.
     *
     * @return void
     */
    public function down()
    {
        //drop role
        Schema::table('committee_user', function (Blueprint $table) {
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
            $table->dropColumn('deleted_at');
            // rename to users_committees_pivot
        });

        Schema::rename('committee_user', 'users_committees_pivot');
    }
};
