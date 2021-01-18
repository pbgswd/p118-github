<?php

use App\Models\Agreement;
use App\Models\Attachment;
use Illuminate\Database\Seeder;

// php artisan db:seed --class=AgreementsTableSeeder

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

        $data = []; // data emptied to prevent multi run without looking

        foreach ($data as $d) {
            $path = trim($d['path']);
            $file = md5($d['file'].time()).'.pdf';

            echo $path."\n";

            if ($d['type'] == 'pdf') {
                $curl = "curl --request GET --user pgordon:05042018 '".str_replace(' ', '%20', $path)."' -o storage/app/agreements/".str_replace(' ', '\ ', $file);
                echo  $curl."\n";
                `$curl`;
                // could also do this for a hashed file name Storage::move('old/file.jpg', 'new/file.jpg');
            }

            $agreement = new Agreement;
            $agreement->user_id = 1;
            $agreement->title = $d['title'];
            $agreement->description = $d['description'];

            $agreement->live = $d['live'];
            $agreement->from = $d['from'];
            $agreement->until = $d['until'];
            $agreement->save();

            $attachment = new Attachment;
            $attachment['user_id'] = 1;
            $attachment['description'] = $d['description'];
            $attachment['file_name'] = $d['file'];
            $attachment['file'] = $file;
            $attachment['subfolder'] = $agreement->getAttachmentFolder();
            $attachment->save();

            $attachment->agreement_id = $agreement->id;
            $agreement->attachments()->attach($attachment);

            unset($d['path']);
            unset($d['file']);

            echo 'done with '.$d['title']."\n";
        }
        echo "\n completely done  \n";
    }
}
