<?php

namespace App\Services;

use App\Http\Requests\Request;

class MessageService
{
    public function __construct(AttachmentService $attachmentService) {
        $this->attachmentService = $attachmentService;
    }
    public function createMessage($data)
    {
        //todo pass in data from posts, pages, committees, other models
        // move in stuff from AdminPostController message method
       // dd($data);
    }

}
