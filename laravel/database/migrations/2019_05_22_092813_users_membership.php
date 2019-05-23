<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UsersMembership extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        // membership user id, user_id,  membership date,
        // //dues state, dues paid until, member seniority number, in good standing?
        // admin_notes(textarea)

        Schema::create('users_membership', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->unique();
            $table->date('membership_date');
            $table->date('membership_expires');
            $table->integer('seniority_number');
            $table->string('status');
            $table->string('admin_notes')->nullable();

            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_membership');
    }
}
