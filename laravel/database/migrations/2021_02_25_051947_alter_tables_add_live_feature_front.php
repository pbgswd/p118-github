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
        Schema::table('features', function (Blueprint $table) {
            $table->string('url')->after('content')->nullable();
            $table->boolean('landing_page')->after('live')->default(1);
            $table->boolean('front_page')->after('live')->default(0);
        });

        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn('sort_order');
            $table->dropColumn('description');
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('description');
            $table->dropColumn('sort_order');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //I want all the columns changed, gone forever
    }
};
