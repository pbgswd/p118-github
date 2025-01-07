<?php

namespace App\Services;

use App\Models\Message;
use App\Models\MessageCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MessageService
{
    public function __construct(AttachmentService $attachmentService) {
        $this->attachmentService = $attachmentService;
    }

    public function createMemoriamMessage($data): Message
    {
        //todo change array, slug,
        $message = [
            'source_url' => $data->source_url,
            'subject' => $data->title,
            'slug' => 'memoriam-'. $data->slug,
            'content' => $data->content,
            'user_id' => Auth::id(),
        ];

        $message['topics'][0]['slug'] = $data->committee->slug;
        $message['attachments'] = $data->attachments;

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
