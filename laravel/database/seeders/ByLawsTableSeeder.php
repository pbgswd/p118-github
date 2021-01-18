<?php

namespace Database\Seeders;

use App\Models\Attachment;
use App\Models\Bylaw;
use Illuminate\Database\Seeder;

// php artisan db:seed --class=ByLawsTableSeeder

class ByLawsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        set_time_limit(0);
        require_once '../scratch/constitution-lawsSeedData.php';

        $data = []; //data emptied to prevent multi run without looking

        foreach ($data as $d) {
            $path = trim($d['path']);
            $file = md5($d['file'].time()).'.pdf';

            echo $path."\n";

            $curl = "curl --request GET --user pgordon:05042018 '".str_replace(' ', '%20', $path)."' -o storage/app/bylaws/".str_replace(' ', '\ ', $file);
            echo  $curl."\n";
            `$curl`;
            // could also do this for a hashed file name Storage::move('old/file.jpg', 'new/file.jpg');

            $bylaw = new Bylaw;
            $bylaw->user_id = 1;
            $bylaw->title = $d['title'];
            $bylaw->description = $d['description'];

            $bylaw->live = $d['live'];
            $bylaw->date = $d['date'];

            $bylaw->save();

            $attachment = new Attachment;
            $attachment['user_id'] = 1;
            $attachment['description'] = $d['description'];
            $attachment['file_name'] = $d['file'];
            $attachment['file'] = $file;
            $attachment['subfolder'] = $bylaw->getAttachmentFolder();
            $attachment->save();

            $attachment->bylaw_id = $bylaw->id;
            $bylaw->attachments()->attach($attachment);

            unset($d['path']);
            unset($d['file']);

            echo 'done with '.$d['title']."\n";
        }
        echo "\n completely done  \n";
    }
}
