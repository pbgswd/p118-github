<?php

namespace App\Http\Controllers;

use App\Http\Requests\Motions\DestroyMotionRequest;
use App\Http\Requests\Motions\StoreMotionRequest;
use App\Http\Requests\Motions\UpdateMotionRequest;
use App\Models\ActivityLog;
use App\Models\Meeting;
use App\Models\Motion;
use App\Models\User;
use App\Services\AttachmentService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
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
    public function store(StoreMotionRequest $request, Meeting $meeting = null): RedirectResponse
    {
        $response = Gate::inspect('create', Motion::class);

        if ($response->denied()) {
            return back()->with('error', $response->message());
        }

        $motion = new Motion($request->validated()['motion']);
        $motion->user_id = auth()->id();

        if (null !== $meeting) {
            $motion->meeting_id = $meeting->id;
        } else {
            $meeting = Meeting::where([['meeting_type', '=', 'General'], ['live', '=',  1], ['date', '>', now()]])
                ->orderBy('date', 'asc')
                ->first() ?? null;
            $motion->meeting_id = $meeting->id ?? null;
        }

        $allowed = false;
        $date = Carbon::now();

        if(null == $meeting) {
            $allowed = true;
        }
        else {
            if($motion->submission_type == 'Motion') {
                $allowed =  $date->diffInDays($motion->meeting->date) - 10 < 0 ? false : true;
            }

            if($motion->submission_type == 'New Business') {
                $allowed =  $date->diffInHours($motion->meeting->date) - 48 < 0 ? false : true;
            }
        }

        if( false == $allowed) {
            return back()->with('error', 'It is too late to create this ' .
                $motion->submission_type .
                '. You can always contact the Executive to discuss.');
        }

        $motion->save();

        if (null !== ($request->file('attachments'))) {
                $result = $this->attachmentService->createAttachment($request, $motion);
                if ($result) {
                    Session::flash('success', 'You uploaded '.
                        count([$request->file('attachments')]) . ' ' .
                        Str::plural('file', count([$request->file('attachments')])));
                }
                else {
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
        $response = Gate::inspect('update', $motion);

        if ($response->denied()) {
            Session::flash('error', 'You are not the author of this ' . $motion->submission_type . ' so you may not edit it.');
        }

        $motion->load('user', 'meeting', 'attachments');

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
        $response = Gate::inspect('update', $motion);

        if ($response->denied()) {
            return back()->with('error', $response->message());
        }

        $motion->load('meeting');

        $allowed = false;
        $date = Carbon::now();

        if(null == $motion->meeting) {
            $allowed = true;
        }
        else {
            // an upcoming meeting
            if($motion->submission_type == 'Motion') {
                $allowed = $date->diffInDays($motion->meeting->date) - 10 < 0 ? false : true;
            }

            if($motion->submission_type == 'New Business') {
                $allowed = $date->diffInHours($motion->meeting->date) - 48 < 0 ? false : true;
            }
        }

        if($allowed == false) {
            return back()->with('error', 'It is too late to edit this '
                . $motion->submission_type .
                '. Contact the Executive to discuss.');
        }

        $data = $request->validated();
        $motion->fill($data['motion']);
        $motion->save();

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
        $id = $motion->id[0];

        $motion = Motion::where('id', $id)->with('attachments')->first();

        $response = Gate::inspect('delete', $motion);

        if ($response->denied()) {
            return back()->with('error', $response->message());
        }

        $al = new ActivityLog([
            'activity' => Auth::user()->name . ' deleted a Motion or New Business, ' . $motion->title,
            'ip_address' => $_SERVER['REMOTE_ADDR'],
            'user_agent' => $_SERVER['HTTP_USER_AGENT'],
            'model' => 'Admin']);

        $al->save();

        //todo send email to notify of deletion

        $this->attachmentService->destroyAttachments($motion);
        $motion->delete();

        Session::flash('success', Str::plural(count([$motion->id]).' Motion', count([$motion->id])).
            ' and any related files deleted.');

        return redirect()->route('list_meetings');
    }
}
