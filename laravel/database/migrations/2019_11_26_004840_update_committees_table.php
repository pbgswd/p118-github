<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCommitteesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //add email
        Schema::table('committees', function (Blueprint $table) {
            $table->string('email')->after('description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //drop email
        Schema::table('committees', function (Blueprint $table) {
            $table->dropColumn('email');
        });
    }
}
