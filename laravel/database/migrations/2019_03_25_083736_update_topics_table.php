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
        /*
         * alter safe name to slug
         * description can be null
         * image can be null
         * drop content
         * drop topic type
         */

        DB::statement('ALTER TABLE topics CHANGE safe_name slug VARCHAR (255) NOT NULL');
        DB::statement('ALTER TABLE topics CHANGE description description TEXT NULL');
        DB::statement('ALTER TABLE topics CHANGE image image varchar(255) NULL');

        Schema::table('topics', function (Blueprint $table) {
            $table->dropColumn('content');                             // drop content
            $table->dropColumn('topic_type');                          // drop content
            // make slug unique
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /*
         * alter slug to safe_name
         * dont change description back to not null
         * image stays null after migration
         * add content col
         * add topic type col
         */

        DB::statement('ALTER TABLE topics CHANGE slug safe_name VARCHAR (255) NOT NULL');

        Schema::table('topics', function (Blueprint $table) {
            // description will stay null
            // image will stay null
            $table->string('content')->after('description');
            $table->enum('topic_type', ['page', 'entry'])->after('in_menu');
        });
    }
};
