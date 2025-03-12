<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Motions\DestroyMotionRequest;
use App\Http\Requests\Motions\StoreMotionRequest;
use App\Http\Requests\Motions\UpdateMotionRequest;
use App\Models\Meeting;
use App\Models\Motion;
use App\Models\Options;
use App\Services\AttachmentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminMotionController extends Controller
{
    private AttachmentService $attachmentService;

    public function __construct(AttachmentService $attachmentService)
    {
        $this->attachmentService = $attachmentService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $motions = Motion::with('user', 'meeting')
            ->orderBy('date', 'desc')
            ->paginate(20);

        $count = Motion::count();

        $data = [
            'motions' => $motions,
            'count' => $count,
        ];

        return view('admin.listmotions', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $this->authorize('create', Motion::class);

            $upcoming = Meeting::withoutGlobalScopes()
            ->where('live', 1)
            ->where('date', '>=', date('Y-m-d'))
            ->withCount('motions')
            ->orderBy('date', 'asc')
            ->get();

        $data = [
            'motion' => new Motion(),
            'motion_types' => Options::motion_types(),
            'upcoming' => $upcoming,
            'action' => 'Create',
        ];

        return view('admin.motion', ['data' => $data]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMotionRequest $request): RedirectResponse
    {
        $motion = new Motion($request->validated()['motion']);
        $motion->user_id = auth()->id();

        $meeting = Meeting::where([['meeting_type', '=', 'General'], ['live', '=',  1], ['date', '>', now()]])->first();

        $motion->meeting_id = $meeting->id ?? null;
        $motion->date = now();

        $motion->save();

        if (null !== ($request->file('attachments'))) {
            $result = $this->attachmentService->createAttachment($request, $motion);
            if ($result) {
                Session::flash('success', 'You uploaded '.count($request->file('attachments')).' files');
            } else {
                Session::flash('error', 'You have an upload problem');
            }
        }



        //todo send email to execs and user and mals to say motion has been submitted

        Session::flash('success', 'You have submitted a ' . $motion->submission_type . ' successfully. It will be reviewed by the Executive.');

        return redirect()->route('admin_motion_edit', $motion->id);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Motion $motion): View
    {
        $this->authorize('update', Motion::class);

        $motion->load('user', 'meeting', 'attachments');

        $upcoming = Meeting::withoutGlobalScopes()
            ->where('live', 1)
            ->where('date', '>=', date('Y-m-d'))
            ->withCount('motions')
            ->orderBy('date', 'asc')
            ->get();

        $data = [
            'motion' => $motion,
            'motion_types' => Options::motion_types(),
            'upcoming' => $upcoming,
            'action' => 'Edit',
        ];

        return view('admin.motion', ['data' => $data]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMotionRequest $request, Motion $motion): RedirectResponse
    {
        $motion->fill($request->validated()['motion']);
        $motion->save();
//todo determine access level
        $result = $this->attachmentService->updateAttachment($request, $motion);
//todo description in file attachments
        if (null !== ($request->file('attachments'))) {
            $result = $this->attachmentService->createAttachment($request, $motion);
            if ($result) {
                Session::flash('success', 'You uploaded '.count($request->file('attachments')).' files');
            } else {
                Session::flash('error', 'You have an upload problem');
            }
        }

        //todo mail updates?

        Session::flash('success', 'You have updated a motion or new business');
        return redirect()->route('admin_motion_edit', $motion->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DestroyMotionRequest $motion): RedirectResponse
    {

        $this->authorize('delete', Motion::class);

        Motion::withoutGlobalScopes()
            ->find($motion->id)
            ->each(function (Motion $motion) {
                $this->attachmentService->destroyAttachments($motion);
                $motion->delete();
            });

        Session::flash('success', Str::plural(count([$motion->id]).' Motion', count([$motion->id])).
            ' and any related files deleted.');

        return redirect()->route('admin_motions_list');

    }
}
