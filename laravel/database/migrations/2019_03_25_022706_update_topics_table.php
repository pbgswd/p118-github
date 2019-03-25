<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*
         * description can be null
         * drop content
         * drop topic type
         * */
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //        /*
        //         * description cannot be null
        //         * add  content
        //         * add  topic type
        //         * */

      //  $table->string('description')->after('safe_name');
        
        $table->string('content')->after('description');
        $table->enum('topic_type',['page','entry'])->after('in_menu');
    }
}
