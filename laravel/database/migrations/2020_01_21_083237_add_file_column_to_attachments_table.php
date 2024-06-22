<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('attachments', function (Blueprint $table) {
            /**
             * change file to file name
             * add file column
             * drop extension?
             */
            $table->renameColumn('name', 'file_name');
        });

        Schema::table('attachments', function (Blueprint $table) {
            /** renameColumn state isnt ready by the time that this next line runs, causing an error */
            $table->string('file')->after('file_name');
            $table->dropColumn('extension');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attachments', function (Blueprint $table) {

            /**
             * change file_name to file
             * drop file column
             * add extension????
             * extenstion permanently lost.
             */
            $table->renameColumn('file_name', 'name');
            $table->dropColumn('file');
        });
    }
};
