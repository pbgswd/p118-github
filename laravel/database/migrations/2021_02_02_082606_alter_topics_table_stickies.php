<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // in_menu allow-comments to front_page landing_page
        Schema::table('topics', function (Blueprint $table) {
            $table->renameColumn('in_menu', 'front_page');
            $table->renameColumn('allow_comments', 'landing_page');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //front_page landing_page to in_menu allow-comments
        Schema::table('topics', function (Blueprint $table) {
            $table->renameColumn('front_page', 'in_menu');
            $table->renameColumn('landing_page', 'allow_comments');
        });
    }
};
