<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use App\Services\AttachmentService;


class MeetingController extends Controller
{
    /**
     * @var AttachmentService
     */
    private $attachmentService;

    public function __construct(AttachmentService $attachmentService)
    {
         $this->attachmentService = $attachmentService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['meetings'] = Meeting::sortable()->with('user')->orderBy('date', 'desc')->paginate(20);
        $data['count'] = count(Meeting::all());

        return view('list_meetings_minutes', ['data' => $data]);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Meeting  $meeting
     * @return \Illuminate\Http\Response
     */
    public function show(Meeting $meeting)
    {
        $meeting->load('user', 'attachments');

        return view('meeting', ['data' => ['meeting' => $meeting]]);
    }

}
