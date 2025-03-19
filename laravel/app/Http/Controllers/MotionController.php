<?php

namespace App\Http\Controllers;

use App\Http\Requests\Motions\DestroyMotionRequest;
use App\Http\Requests\Motions\StoreMotionRequest;
use App\Http\Requests\Motions\UpdateMotionRequest;
use App\Models\ActivityLog;
use App\Models\Meeting;
use App\Models\Motion;
use App\Services\AttachmentService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
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
        //todo policy

        $motion = new Motion($request->validated()['motion']);
        $motion->user_id = auth()->id();

        //todo enforce input, meeting must be 10 days away to allow for attachment to meeting
        //todo

        $meeting = Meeting::where([['meeting_type', '=', 'General'], ['live', '=',  1], ['date', '>', now()]])
            ->orderBy('date', 'asc')
            ->first();

        $allowed = false;
        $date = Carbon::now();

        if(null == $meeting) {
          // no upcoming meeting
            $allowed = true;
        }
        else {
            // an upcoming meeting
            if($motion->submission_type == 'Motion') {
                $allowed =  $date->diffInDays($meeting->date) - 10 > $date ?? false;
            }
            if($motion->submission_type == 'New Business') {
                $allowed =  $date->diffInHours($meeting->date)-10 > $date ? true : false;
            }
        }

        if($allowed) {

            $motion->meeting_id = $meeting->id ?? null;

            $motion->save();

            if (null !== ($request->file('attachments'))) {
                $result = $this->attachmentService->createAttachment($request, $motion);
                if ($result) {
                    Session::flash('success', 'You uploaded '.
                        count([$request->file('attachments')]) .' ' .
                        Str::plural('file', count([$request->file('attachments')])));
                } else {
                    Session::flash('error', 'You have an upload problem');
                }
            }

            //todo send email to execs and user and mals to say motion has been submitted

            Session::flash('info', 'You have submitted a ' . $motion->submission_type .
                ' successfully. It will be reviewed by the Executive.');

            $al = new ActivityLog([
                'activity' => Auth::user()->name . ' created a Motion or New Business, ' . $motion->title,
                'ip_address' => $_SERVER['REMOTE_ADDR'],
                'user_agent' => $_SERVER['HTTP_USER_AGENT'],
                'model' => 'Admin']);

            $al->save();

        }
        else {
            Session::flash('warning', 'Cant submit this. Contact the Executive to discuss.');
        }

        return redirect()->route('list_meetings');
    }

    /**
     * Display the specified resource.
     */
    public function show(Motion $motion): View
    {
        $motion->load('user', 'meeting', 'attachments');

        $data = [
            'motion' => $motion,
            'title' => $motion->submission_type . ' ' . $motion->title,
        ];

        return view('motion', ['data' => $data]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Motion $motion): View
    {
        //todo policy

        $motion->load('user', 'meeting', 'attachments');

//todo dont allow editing after date limits based on date/New Motion/New Business

        $upcoming = Meeting::withoutGlobalScopes()
            ->where('live', 1)
            ->where('date', '>=', date('Y-m-d'))
            ->withCount('motions')
            ->orderBy('date', 'asc')
            ->first();

        $data = [
            'action' => 'Edit',
            'motion' => $motion,
            'upcoming' => $upcoming,
            'title' => 'Edit ' . $motion->submission_type . ' ' . $motion->title,
        ];

        return view('motion-edit', ['data' => $data]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMotionRequest $request, Motion $motion): RedirectResponse
    {
        //todo policy

        $data = $request->validated();
        $motion->fill($data['motion']);
        $motion->save();

//todo file attachments - handle description, delete
        //todo default access level


        $result = $this->attachmentService->updateAttachment($request, $motion);

        if (null !== ($request->file('attachments'))) {
            $result = $this->attachmentService->createAttachment($request, $motion);
            if ($result) {
                Session::flash('success', 'You uploaded '.
                    count([$request->file('attachments')]) .' ' .
                    Str::plural('file', count([$request->file('attachments')])));
            } else {
                Session::flash('error', 'You have an upload problem');
            }
        }




        //todo send email to execs and user and mals to say motion has been submitted

        $al = new ActivityLog([
            'activity' => Auth::user()->name . ' updated a Motion or New Business, ' . $motion->title,
            'ip_address' => $_SERVER['REMOTE_ADDR'],
            'user_agent' => $_SERVER['HTTP_USER_AGENT'],
            'model' => 'Admin']);
        $al->save();


        Session::flash('info', 'You have updated the ' . $motion->submission_type . ' successfully. It will be reviewed by the Executive.');
        return redirect()->route('motion_edit', $motion->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DestroyMotionRequest $motion): RedirectResponse
    {
        //todo update policy

        $this->authorize('delete', Motion::class);

        $al = new ActivityLog([
            'activity' => Auth::user()->name . ' deleted a Motion or New Business, ' . $motion->title,
            'ip_address' => $_SERVER['REMOTE_ADDR'],
            'user_agent' => $_SERVER['HTTP_USER_AGENT'],
            'model' => 'Admin']);
        $al->save();

        //todo send email to notify of deletion


        Motion::withoutGlobalScopes()
            ->find($motion->id)
            ->each(function (Motion $motion) {
                $this->attachmentService->destroyAttachments($motion);
                $motion->delete();
            });

        Session::flash('success', Str::plural(count([$motion->id]).' Motion', count([$motion->id])).
            ' and any related files deleted.');

        return redirect()->route('list_meetings');
    }
}
