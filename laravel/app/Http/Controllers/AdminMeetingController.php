<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use App\Models\MeetingAttachment;
use App\Services\AttachmentService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class AdminMeetingController extends Controller
{
    /** @var AttachmentService*/
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
        $data = [];
        $data['meetings'] = Meeting::sortable()->with('user')->orderBy('date', 'desc')->paginate(20);
        $data['count'] = count(Meeting::all());

        return view('admin.listmeetings', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $meeting = new Meeting();
        $meeting->live = 1;

        return view('admin.meeting', ['data' => ['meeting' => $meeting, 'action' => 'Add']]);
    }


    /**
     * Store a newly created resource in storage
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $meeting = new Meeting($request->input('meeting'));
        $meeting->user_id = Auth::id();
        $meeting->save();

        Session::flash('success', "Meeting saved");

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
        //todo delete show method for admin meeting controller
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Meeting  $meeting
     * @return \Illuminate\Http\Response
     */
    public function edit(Meeting $meeting)
    {
        $meeting->load('user', 'attachments');

        return view('admin.meeting', ['data' => ['meeting' => $meeting, 'action' => 'Edit']]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Meeting  $meeting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Meeting $meeting)
    {

        $meeting->fill($request['meeting']);
        $meeting->save();

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

        Session::flash('success', "You have edited the meeting information");

        return redirect()->route('meeting_edit', [$meeting->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Meeting  $meeting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $meetings = Meeting::find($request->id);

        foreach($meetings as $meeting)
        {
            $result = $this->attachmentService->destroyAttachment($meeting);

            Meeting::destroy($meeting->id);
        }

        Session::flash('success', Str::plural(count($request->id) . ' Meeting', count($request->id)) . ' and any related files deleted.');

        return redirect()->route('meetings_list');
    }
}
