<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // todo data from options for executive
        DB::table('executives')->insert(
            [
                ['title' => 'President',
                    'email' => 'president@iatse118.com',
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now(), ],
                ['title' => 'Vice President',
                    'email' => 'vicepresident@iatse118.com',
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now(), ],
                ['title' => 'Business Agent',
                    'email' => 'businessagent@iatse118.com',
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now(), ],
                ['title' => 'Financial Secretary',
                    'email' => 'financialsecretary@iatse118.com',
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now(), ],
                ['title' => 'Member At Large',
                    'email' => 'memberatlarge1@iatse118.com',
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now(), ],
                ['title' => 'Member At large',
                    'email' => 'memberatlarge2@iatse118.com',
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now(), ],
                ['title' => 'Health And Welfare',
                    'email' => 'healthandwelfare@iatse118.com',
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now(), ],
                ['title' => 'Constitution and By-laws',
                    'email' => 'constitution@iatse118.com',
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
        DB::table('executives')->truncate();
    }
};
