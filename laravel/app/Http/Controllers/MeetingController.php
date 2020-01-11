<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use App\Models\MeetingAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;




class MeetingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [];
        $data['meetings'] = Meeting::sortable()->with('user')->orderBy('date')->paginate(10);

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

        foreach ($request->file('files') as $file) {

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

        dd($request->all());

        $meeting->fill($request['meeting']);
        $meeting->save();

        //todo update meeting attachements files and description -- any to save, any to delete?




        Session::flash('success', "You have edited the meeting information");

        return redirect()->route('meeting_edit', [$meeting->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Meeting  $meeting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Meeting $meeting)
    {
        $meeting = Meeting::find($request->id);
        dd($meeting);
        /*       // dd($request->all());
                foreach($request as $r => $k)
                {
                    //dd($r[0]);
                    ->first();
                    dd($meeting);
                    Meeting::destroy($meeting->id);
                }*/
        Session::flash('success', Str::plural(count($request) . ' Meeting', count($request)) . ' NOT deleted.');
        return redirect()->route('meetings_list');
    }
}
