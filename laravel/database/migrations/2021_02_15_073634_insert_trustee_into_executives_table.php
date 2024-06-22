<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('executives')->insert(
            [['title' => 'Trustee',
                'email' => 'trustee@iatse118.com',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(), ],
            ]
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $result = DB::table('executives')->where('title', 'Trustee')->get();
        DB::table('executive_user')->where('executive_id', $result->id)->delete();
        DB::table('executives')->where('title', 'Trustee')->delete();
    }
};
