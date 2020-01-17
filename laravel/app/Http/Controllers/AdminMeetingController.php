<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use App\Models\MeetingAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use App\Services\AttachmentService;



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

        if (null !== ($request->file('meeting_attachments'))) {
//todo laravel service line 71, what arguments are passed?

            $this->attachmentService->createAttachment(FormRequest);

            foreach ($request->file('meeting_attachments') as $file) {

                $fileName = $file->getClientOriginalName();

                if (!$file->storeAs('meetings', $fileName)) {
                    Session::flash('warning', "Did not store " . $fileName);
                    return null;
                }

                $meeting_attachment = new MeetingAttachment();
                $meeting_attachment['file'] = $fileName;
                $meeting_attachment['extension'] =     $file->getClientOriginalExtension();
                $meeting_attachment['meeting_id'] = $meeting->id;
                $meeting_attachment->save();
                Session::flash('success', "You have saved " . $fileName);
            }
        }
        Session::flash('success', "You have saved a new meeting");

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
        //
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
    public function update(Request $request, Meeting $meeting, MeetingAttachment $meetingAttachment)
    {
        $meeting->fill($request['meeting']);
        $meeting->save();
        $meeting->attachments;

        if (null !== ($request->file('meeting_attachments'))) {
            foreach ($request->file('meeting_attachments') as $file) {

                $fileName = $file->getClientOriginalName();

                if (!$file->storeAs('meetings', $fileName)) {
                    Session::flash('warning', "Did not store " . $fileName);
                    return null;
                }

                $meeting_attachment = new MeetingAttachment();
                $meeting_attachment['file'] = $fileName;
                $meeting_attachment['extension'] = $file->getClientOriginalExtension();
                $meeting_attachment['meeting_id'] = $meeting->id;
                $meeting_attachment->save();
            }
        }

        if(isset($request->meeting_attachment)){
            foreach($request->meeting_attachment as $k => $ma) {
                if (isset($ma['id'])) {
                    $row = MeetingAttachment::where('id', $ma['id'])->get();
                    Storage::disk('meetings')->delete($row[0]['file']);
                    MeetingAttachment::destroy($row[0]->id);
                }
                else
                {
                    $row = MeetingAttachment::where('id', $k)->first();
                    $row->description = trim($ma['description']);
                    $row->save();
                }
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
            $meeting->attachments;
            foreach ( $meeting->attachments as $row){
                Storage::disk('meetings')->delete($row['file']);
                MeetingAttachment::destroy($row->id);
            }

            Meeting::destroy($meeting->id);
        }

        Session::flash('success', Str::plural(count($request->id) . ' Meeting', count($request->id)) . ' and any related files deleted.');

        return redirect()->route('meetings_list');
    }
}
