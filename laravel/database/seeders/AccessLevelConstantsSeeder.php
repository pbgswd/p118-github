<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccessLevelConstantsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
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
