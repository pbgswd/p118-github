<?php

namespace App\Services;

use App\Models\Attachment;
use App\Models\Interfaces\HasAttachment;
use Illuminate\Http\Request;

class AttachmentService
{
    //todo develop AttachmentService
    public function createAttachment(Request $request, HasAttachment $model): bool
    {
        foreach ($request->file('attachments') as $file) {

            $fileName = $file->getClientOriginalName();

            if (!$file->storeAs($model->getAttachmentFolder(), $fileName)) {
                return false;
                    //todo return value to allow controller to handle this case with Session::flash msg
            }

            $attachment = new Attachment;
            $attachment['file'] = $fileName;
            $attachment['extension'] = $file->getClientOriginalExtension();
            //todo pivot tables for this
            //$attachment['meeting_id'] = $model->id;
            $attachment->save();
            $model->attach($attachment);
        }

        return true;
    }

}
