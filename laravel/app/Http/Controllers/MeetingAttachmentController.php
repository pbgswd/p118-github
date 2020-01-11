<?php

namespace App\Http\Controllers;

use App\Models\MeetingAttachment;
use App\ModelsMeetingAttachment;
use Illuminate\Http\Request;

class MeetingAttachmentController extends Controller
{
    /**
     * Download the resource
     *
     */
    public function download(MeetingAttachment $meetingAttachment)
    {
        dd($meetingAttachment);
        $pathToFile = MeetingAttachment::getStoragePath();
        return response()->download($pathToFile.$meetingAttachment['file']);
    }
}
