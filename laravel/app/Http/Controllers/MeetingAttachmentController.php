<?php

namespace App\Http\Controllers;

use App\Models\MeetingAttachment;
use Illuminate\Support\Facades\Storage;

class MeetingAttachmentController extends Controller
{
    /**
     * Download the resource
     *
     */
    public function download(MeetingAttachment $meetingAttachment)
    {
        $pathToFile = Storage::disk('meetings')->getDriver()->getAdapter()->getPathPrefix();
        return response()->download($pathToFile.$meetingAttachment['file']);
    }
}
