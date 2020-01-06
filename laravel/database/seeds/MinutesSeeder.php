<?php

use Illuminate\Database\Seeder;

class MinutesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        require_once '../../scratch/minutes_array.php';

        foreach ($files as $file)
        {
            $doc = explode('/', $file['path']);
            $result = explode('-', $file['title']);
            $title = trim($result[0]);
            $date = date_format(new DateTime(trim($result[1])),  'Y-m-d H:i:s');
            $data[] = ['path' => $file['path'], 'file' => $doc[1], 'title' => $title, 'date' => $date];
        }

//TODO: db insert live data
    }
}
