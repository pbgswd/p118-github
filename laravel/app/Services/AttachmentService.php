<?php

namespace App\Services;

use App\Models\Attachment;
use App\Models\Interfaces\HasAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AttachmentService
{

    /**
     * @param Request $request
     * @param HasAttachment $model
     * @return bool
     */
    public function createAttachment(Request $request, HasAttachment $model): bool
    {
        foreach ($request->file('attachments') as $file)
        {
        //todo what about max file size, number of files uploaded at a time, resizing images generate thumb $file
            $attachment = new Attachment;
            $attachment['user_id'] = Auth::id();

            $attachment['file_name'] = $file->getClientOriginalName();
            $attachment['file'] = $file->store('', $model->getAttachmentFolder());
            $attachment['subfolder'] = $model->getAttachmentFolder();

            $attachment->save();

            $model->attachments()->attach($attachment);
        }
        return true;
    }

    /**
     * @param Request $request
     * @param HasAttachment $model
     * @return bool
     */
    public function updateAttachment(Request $request, HasAttachment $model): bool
    {
    //todo will updateAttachment work with everything?
        if(isset($request->attachment)) {
            foreach ($request->attachment as $k => $v )
            {
                $attachment = Attachment::where('id', $k)->first();
                $attachment->description = trim($v['description']);
                $attachment->save();

                if (isset($v['id'])) {
                    Storage::disk($model->getAttachmentFolder())->delete($attachment['file']);
                    Attachment::destroy($v['id']);
                }
            }
            return true;
        }
        else {
            return false;
        }
    }

    /**
     * @param Request $request
     * @param HasAttachment $model
     * @return bool
     */
    public function destroyAttachment(HasAttachment $model): bool
    {
        $model->attachments;

        foreach ($model->attachments as $attachment)
        {
            Storage::disk($model->getAttachmentFolder())->delete($attachment['file']);

            Attachment::destroy($attachment['id']);
        }
        return true;
    }

    /**
     * @param Attachment $attachment
     * @param string $folder
     * @return mixed
     */
    public function downloadAttachment(Attachment $attachment, string $folder)
    {
        return Storage::download( $folder . '/' . $attachment['file'], $attachment['file_name'], [], null );
    }

}





















