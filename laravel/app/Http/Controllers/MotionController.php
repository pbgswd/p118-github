<?php

namespace App\Http\Controllers;

use App\Http\Requests\Motions\StoreMotionRequest;
use App\Http\Requests\Motions\UpdateMotionRequest;
use App\Models\Meeting;
use App\Models\Motion;
use App\Services\AttachmentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class MotionController extends Controller
{
    public function __construct(public AttachmentService $attachmentService)
    {
    }

        /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMotionRequest $request): RedirectResponse
    {
        $motion = new Motion($request->validated()['motion']);
        $motion->user_id = auth()->id();

        //todo enforce input, meeting must be 10 days away to allow for attachment to meeting
        //todo

        $meeting = Meeting::where([['meeting_type', '=', 'General'], ['live', '=',  1], ['date', '>', now()]])->first();
        $motion->meeting_id = $meeting->id ?? null;
        $motion->date = now();

        $motion->save();

        if (null !== ($request->file('attachments'))) {
            $result = $this->attachmentService->createAttachment($request, $motion);
            if ($result) {
                Session::flash('success', 'You uploaded '.
                    count([$request->file('attachments')]).' files');
            } else {
                Session::flash('error', 'You have an upload problem');
            }
        }


        //todo send email to execs and user and mals to say motion has been submitted

        Session::flash('success', 'You have submitted a ' . $motion->submission_type . ' successfully. It will be reviewed by the Executive.');

        return redirect()->route('list_meetings');
    }

    /**
     * Display the specified resource.
     */
    public function show(Motion $motion): View
    {
        $motion->load('user', 'meeting', 'attachments');
//dd($motion);
        return view('motion', ['data' => ['motion' => $motion]]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Motion $motion): View
    {
        $motion->load('user', 'meeting', 'attachments');


        $upcoming = Meeting::withoutGlobalScopes()
            ->where('live', 1)
            ->where('date', '>=', date('Y-m-d'))
            ->withCount('motions')
            ->orderBy('date', 'asc')
            ->get();


        $newmotions = Motion::where('meeting_id', null)->with('user')->get();

        $data = [
            'action' => 'Edit',
            'motion' => $motion,
            'upcoming' => $upcoming,
            'newmotions' => $newmotions,
        ];


        return view('motion-edit', ['data' => $data]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMotionRequest $request, Motion $motion): RedirectResponse
    {

        return redirect('motion_edit', $motion->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Motion $motion)
    {
        //
    }
}
