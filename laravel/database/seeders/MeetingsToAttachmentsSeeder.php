<?php

namespace Database\Seeders;

use App\Models\Attachment;
use App\Models\Meeting;
use App\Models\MeetingAttachment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MeetingsToAttachmentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // need to move via DB because the relationship no longer exists

        // php artisan db:seed --class=MeetingsToAttachmentsSeeder
        set_time_limit(0);

        $data = DB::table('meetings')
            ->join('meeting_attachments', 'meetings.id', '=', 'meeting_attachments.meeting_id')->get();

        foreach ($data as $m) {
            $attachment = new Attachment;

            $attachment->user_id = $m->user_id;
            $attachment->description = $m->description;
            $attachment->file_name = $m->file;
            $attachment->file = $m->file;
            $attachment->subfolder = 'meetings';

            $attachment->created_at = $m->created_at;
            $attachment->updated_at = $m->updated_at;

            $attachment->save();

            $attachment->meeting_id = $m->meeting_id;
            $attachment->attachment_id = $attachment->id;

            DB::table('attachment_meeting')
                ->insert(['attachment_id' => $attachment->id, 'meeting_id' => $m->id]);
        }
        echo "\n ****** done ****** \n";
    }
}
