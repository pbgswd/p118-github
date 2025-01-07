<?php

namespace App\Services;

use App\Models\Message;
use App\Models\MessageCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MessageService
{
    private AttachmentService $attachmentService;
    public function __construct(AttachmentService $attachmentService) {
        $this->attachmentService = $attachmentService;
    }

    public function createMeetingMessage($data): Message
    {
        $additional_data = "<hr />
                            <b>Date of Meeting: " . $data['date']->format('F j Y') ."</b>
                            </b>";

        $message = [
            'source_url' => $data->source_url,
            'subject' => "Meeting Minutes: " . $data->title,
            'slug' => 'meeting-minutes-'. $data->id,
            'content' => $data->description . $additional_data,
            'user_id' => Auth::id(),
        ];

        $message['topics'][0]['slug'] = 'Meeting';
        $message['attachments'] = $data->attachments;

        return self::createMessage($message, 'model');
    }


    public function createEmploymentMessage($data): Message
    {

        $additional_data = "<hr />
                            <b>Date Posted: " . $data['created_at']->format('F j Y') ."</b>
                            <br />
                            <b>End date for application: " . $data['deadline']->format('F j Y') .
                            "</b>";

        $message = [
            'source_url' => $data->source_url,
            'subject' => "Job Posting: " . $data->title,
            'slug' => 'job-posting-'. $data->id,
            'content' => $data->description . $additional_data,
            'user_id' => Auth::id(),
        ];

        $message['topics'][0]['slug'] = 'Employment';
        $message['attachments'] = $data->attachments;

        return self::createMessage($message, 'model');
    }

    public function createMemoriamMessage($data): Message
    {
        $message = [
            'source_url' => $data->source_url,
            'subject' => "In Memoriam: ". $data->title,
            'slug' => 'in-memoriam-'. $data->slug,
            'content' => $data->content,
            'user_id' => Auth::id(),
        ];

        $message['topics'][0]['slug'] = 'Memoriam';
        $message['attachments'] = [];

        return self::createMessage($message, 'model');
    }

    public function createCommitteePostMessage($data): Message
    {
        $message = [
            'source_url' => $data->source_url,
            'subject' => $data->title,
            'slug' => $data->committee->slug .'-'. $data->slug,
            'content' => $data->content,
            'user_id' => Auth::id(),
        ];

        $message['topics'][0]['slug'] = $data->committee->slug;
        $message['attachments'] = $data->attachments;

        return self::createMessage($message, 'committee');
    }

    public function createPageMessage($data): Message
    {
        $message = [
            'source_url' => $data->source_url,
            'subject' => $data->title,
            'slug' => $data->slug,
            'content' => $data->content,
            'user_id' => Auth::id(),
        ];

        $message['topics'] = $data['topics'];
        $message['attachments'] = $data->attachments;

        return self::createMessage($message, 'topic');

    }
    public function createPostMessage($data): Message
    {
        $message = [
            'source_url' => $data->source_url,
            'subject' => $data->title,
            'slug' => $data->slug,
            'content' => $data->content,
            'user_id' => Auth::id(),
        ];

        $message['topics'] = $data['topics'];
        $message['attachments'] = $data->attachments;

        return self::createMessage($message, 'topic');
    }

    public function createMessage($data, $msg_category_type): Message
    {

        $msg = new Message($data);
        $msg->save();

        foreach ($data['topics'] as $topic) {
            $msg_category['message_id'] = $msg->id;
            $msg_category['type'] = $msg_category_type;
            $msg_category['name'] = $topic['slug'];
            $msgCategory = new MessageCategory($msg_category);
            $msgCategory->save();
        }

        foreach($data['attachments'] as $attachment) {
            $attachment_data = [
                'attachment_id' => $attachment->id,
                'message_id' => $msg->id,
            ];
            $result = DB::table('attachment_message')
                ->insert([$attachment_data]);
        }
        return $msg;
    }
}
