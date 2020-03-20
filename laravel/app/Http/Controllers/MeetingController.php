<?php

namespace App\Http\Controllers;

use App\Http\Requests\Meetings\DestroyMeeting;
use App\Http\Requests\Meetings\StoreMeeting;
use App\Http\Requests\Meetings\UpdateMeeting;
use App\Models\Meeting;
use App\Services\AttachmentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $meeting = new Meeting;
        return view('meeting', ['data' => ['meeting' => $meeting, 'action' => 'Add']]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreMeeting $request)
    {
        $this->authorize('create', Auth::user());

        $meeting = new meeting($request->input('meeting'));
        $meeting->user_id = Auth::id();
        $meeting->access_level = 'members';
        $meeting->save();

        Session::flash('success', "meeting post saved");

        if (null !== ($request->file('attachments'))) {
            $result = $this->attachmentService->createAttachment($request, $meeting);

            if($result) {
                Session::flash('success', "You uploaded " . count($request->file('attachments')) . " files");
            }
            else
            {
                Session::flash('error', "You have an upload problem");
            }
        }
        return redirect()->route('meeting_edit', [$meeting->id]);

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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Meeting  $meeting
     * @return \Illuminate\Http\Response
     */
    public function edit(Meeting $meeting)
    {
        //
    }

    /**
     * @param UpdateMeeting $request
     * @param Meeting $meeting
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateMeeting $request, Meeting $meeting)
    {
        $this->authorize('update', Auth::user());


        $result = $this->attachmentService->updateAttachment($request, $meeting);

        if (null !== ($request->file('attachments')))
        {
            $result = $this->attachmentService->createAttachment($request, $meeting);

            if($result){
                Session::flash('success', "You uploaded " . count($request->file('attachments')) . " files");
            }
            else
            {
                Session::flash('error', "You have an upload problem");
            }
        }


    }

    /**
     * @param DestroyMeeting $meeting
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(DestroyMeeting $meeting)
    {
        $this->authorize('destroy', Auth::user());
    }
}
