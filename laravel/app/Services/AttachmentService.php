<?php

namespace App\Services;

use App\Constants\AccessLevelConstants;
use App\Models\Attachment;
use App\Models\Interfaces\HasAttachment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class AttachmentService
{
    public function createAttachment(Request $request, HasAttachment $model): bool
    {
        foreach ($request->file('attachments') as $file) {
            $attachment = new Attachment;
            $attachment->user_id = Auth::id();
            $attachment->access_level = $model->getAttachmentAccessLevel();

            $fileTypes = [
                'pdf' => 'pdf',
                'zip' => 'zip',
                'bin' => 'binary',
            ];
//todo move to mutator method in Attachment Model, called setFileTypeAttribute
            $attachment['file_name'] = $file->getClientOriginalName();
            $attachment['file'] = $file->store('', $model->getAttachmentFolder());
            $attachment['subfolder'] = $model->getAttachmentFolder();

            $file_extension = strtolower(File::extension('storage/' . $attachment->subfolder . '/' . $attachment->file));
            $file_type = $fileTypes[$file_extension] ?? (
                in_array($file_extension, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg']) ? 'image' : 'file'
            );

            $attachment['file_type'] = $file_type;

            $attachment->save();

            $model->attachments()->attach($attachment);
        }

        return true;
    }

    public function updateAttachment(Request $request, HasAttachment $model): bool
    {
        if (isset($request->attachment)) {
            foreach ($request->attachment as $k => $v) {
                $attachment = Attachment::find($k);

                if (isset($v['id'])) {
                    if ($model->keepDissociatedAttachments()) {
                        $model->attachments()->detach($attachment);
                    } else {
                        Storage::disk($model->getAttachmentFolder())->delete($attachment['file']);
                        Attachment::destroy($v['id']);
                    }

                    continue;
                }

                $keys = array_keys($request->attachment);

                foreach ($keys as $k) {
                    if ($attachment->id == $k) {
                        $attachment->access_level = $request->attachment[$k]['access_level'];
                        $attachment->description = \trim($request->attachment[$k]['description']);
                        $attachment->save();
                    }
                }
            }

            return true;
        }

        return false;
    }

    public function destroyAttachments(HasAttachment $model): bool
    {
        $model->load('attachments');

        foreach ($model->attachments as $attachment) {
            Storage::disk($model->getAttachmentFolder())->delete($attachment['file']);
            Attachment::destroy($attachment['id']);
        }

        return true;
    }

    public function downloadAttachment(Attachment $attachment, string $folder): RedirectResponse|\Symfony\Component\HttpFoundation\StreamedResponse
    {
        if (Auth::check() === false && $attachment->access_level != AccessLevelConstants::PUBLIC) {
            Session::flash('error', 'Please log in first and try the download link again.');

            return redirect()->route('login');
        } else {
            return Storage::download($folder.'/'.$attachment['file'],
                $attachment['file_name'], ['Content-Disposition' => 'inline; filename="'.$attachment['file_name'].'"']);
        }
    }

    public static function human_filesize($bytes, int $decimals = 2): string
    {
        $factor = \floor((\strlen($bytes) - 1) / 3);

        $sz = '';
        if ($factor > 0) {
            $sz = 'KMGT';
        }

        return \sprintf("%.{$decimals}f", $bytes / (1024 ** $factor)).@$sz[$factor - 1].'B';
    }
}
