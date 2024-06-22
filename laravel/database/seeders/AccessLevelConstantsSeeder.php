<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccessLevelConstantsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('access_level_constants')->insert([
            [
                'access_level' => 'members',
                'display' => 'Members',
            ],
            [
                'access_level' => 'public',
                'display' => 'Public',
            ],
        ]);
    }
}
