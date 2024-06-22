<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExecutiveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        DB::table('executives')->insert([
            ['title' => 'President', 'email' => 'president@iatse118.com'],
            ['title' => 'Vice President', 'email' => 'vicepresident@iatse118.com'],
            ['title' => 'Business Agent', 'email' => 'businessagent@iatse118.com'],
            ['title' => 'Treasurer', 'email' => 'treasurer@iatse118.com'],
            ['title' => 'Member At Large', 'email' => 'memberatlarge1@iatse118.com'],
            ['title' => 'Member At Large', 'email' => 'memberatlarge2@iatse118.com'],
            ['title' => 'Health & Welfare Administrator', 'email' => 'healthandwealfare@iatse118.com'],
            ['title' => 'Recording Secretary', 'email' => 'recsec@iatse118.com'],
            ['title' => 'Trustee', 'email' => 'trustee@iatse118.com'],
        ]);
    }
}
