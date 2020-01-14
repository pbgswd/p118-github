<?php

use Illuminate\Database\Seeder;


class MinutesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Exception
     */
    public function run()
    {
        // php artisan db:seed --class=MinutesSeeder
     set_time_limit(0);
       // require_once '../scratch/archivemeetingsLocal118.php';
       // $result = $archive_result;

        //require_once '../scratch/meetings1-118.php';  // result

        //require_once '../scratch/minutes_array.php';
        //$result = $minutes_array;

        $i = 1;
        $limit = 500000;

        foreach ($result as $r) {

            $path = $r['path'];
            $file = $r['file'];

            unset($r['path']);
            unset($r['file']);

            /*
            $curl = "curl  --request GET --user pgordon:05042018 'http://iatse118.com/members/" . str_replace(' ', '%20', $path) . "' -o storage/app/meetings/" . str_replace(' ', '\ ', $file);
            echo $curl . "\n";
            `$curl`;
            */

            $meeting = new \App\Models\Meeting($r);
            $meeting->description = $r['title'] . ". See attached document.";
            $meeting->user_id = 1;
            $meeting->live = 1;
            $meeting->save();

            $meeting_attachment = new \App\Models\MeetingAttachment();
            $meeting_attachment['file'] = $file;
            $meeting_attachment['extension'] = pathinfo($file, PATHINFO_EXTENSION);
            $meeting_attachment['meeting_id'] = $meeting->id;
            $meeting_attachment['description'] = $meeting->title;
            $meeting_attachment->save();

            if ($i == $limit) {
                echo "\n *** done *** \n";
                exit();
            } else {
                $i++;
            }

        }

        echo "---------------done \n";
//TODO attach minutes



    }



       /* foreach ($files as $file)
        {
            $doc = explode('/', $file['path']);
            $result = explode('-', $file['title']);
            $title = trim($result[0]);
            $date = date_format(new DateTime(trim($result[1])),  'Y-m-d H:i:s');
            $data[] = ['path' => $file['path'], 'file' => $doc[1], 'title' => $title, 'date' => $date];
        }*/

//TODO: db insert live data

}
