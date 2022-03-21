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
        DB::table('executives')->insert(
            [['title' => 'Trustee',
                'email' => 'trustee@iatse118.com',
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(), ],
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $result = DB::table('executives')->where('title', 'Trustee')->get();
        DB::table('executive_user')->where('executive_id', $result->id)->delete();
        DB::table('executives')->where('title', 'Trustee')->delete();
    }
};
