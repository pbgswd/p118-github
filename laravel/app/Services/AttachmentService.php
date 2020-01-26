<?php

namespace App\Services;

use App\Models\Attachment;
use App\Models\Interfaces\HasAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttachmentService
{
    public function createAttachment(Request $request, HasAttachment $model): bool
    {
        foreach ($request->file('attachments') as $file)
        {
            //todo what about max file size, number of files uploaded at a time, resizing images generate thumb $file
            $attachment = new Attachment;
            $attachment['user_id'] = Auth::id();
            $attachment['file'] = $file->store('', $model->getAttachmentFolder());
            $attachment['file_name'] = $file->getClientOriginalName();

            $attachment->save();

            $model->attachments()->attach($attachment);
        }
        return true;
    }
}
