<?php

namespace Database\Seeders;

use App\Models\Attachment;
use App\Models\Employment;
use Illuminate\Database\Seeder;

class EmploymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // php artisan db:seed --class=EmploymentSeeder
        set_time_limit(0);
        require_once '../scratch/employmentSeedData.php';

        $data = []; // data emptied to prevent multi run without looking

        foreach ($data as $d) {
            $path = trim($d['path']);
            $file = md5($d['file'].time()).'.pdf';

            echo $path."\n";

            if ($d['type'] == 'pdf') {
                $curl = "curl --request GET --user pgordon:05042018 '".str_replace(' ', '%20', $path)."' -o storage/app/employment/".str_replace(' ', '\ ', $file);
                echo  $curl."\n";

                `$curl`;

                // could also do this for a hashed file name Storage::move('old/file.jpg', 'new/file.jpg');
            }

            $employment = new Employment;
            $employment->user_id = 1;
            $employment->title = $d['title'];
            $employment->description = $d['description'];
            $employment->url = $d['url'];
            $employment->status = $d['status'];
            $employment->live = $d['live'];
            $employment->deadline = $d['deadline'];
            $employment->save();

            $attachment = new Attachment;
            $attachment['user_id'] = 1;
            $attachment['description'] = $d['description'];
            $attachment['file_name'] = $d['file'];
            $attachment['file'] = $file;
            $attachment['subfolder'] = $employment->getAttachmentFolder();
            $attachment->save();

            /**   DB::table('attachment_employment').
                ->insert(['attachment_id' => $attachment->id, 'employment_id' => $employment->id]);
             */
            $attachment->employment_id = $employment->id;
            $employment->attachments()->attach($attachment);

            unset($d['path']);
            unset($d['file']);
        }
    }
}
