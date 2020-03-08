<?php

use Illuminate\Database\Seeder;
use App\Models\Attachment;
use App\Models\Agreement;


class AgreementsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        set_time_limit(0);
        require_once '../scratch/agreementsSeedData.php';

        
    }
}
