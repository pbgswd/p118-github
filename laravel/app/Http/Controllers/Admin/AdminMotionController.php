<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Motions\DestroyMotionRequest;
use App\Http\Requests\Motions\StoreMotionRequest;
use App\Http\Requests\Motions\UpdateMotionRequest;
use App\Models\ActivityLog;
use App\Models\Meeting;
use App\Models\Motion;
use App\Models\Options;
use App\Services\AttachmentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
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
            ->orderBy('updated_at', 'desc')
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
        //todo policy

        $motion = new Motion($request->validated()['motion']);
        $motion->user_id = auth()->id();

        $meeting = Meeting::where([['meeting_type', '=', 'General'], ['live', '=',  1], ['date', '>', now()]])->first();

        $motion->meeting_id = $meeting->id ?? null;

        $motion->save();

        if (null !== ($request->file('attachments'))) {
            $result = $this->attachmentService->createAttachment($request, $motion);
            if ($result) {
                Session::flash('success', 'You uploaded '.count($request->file('attachments')).' files');
            } else {
                Session::flash('error', 'You have an upload problem');
            }
        }

        Session::flash('success', 'You have submitted a ' . $motion->submission_type . ' successfully. It will be reviewed.');

        return redirect()->route('admin_motion_edit', $motion->id);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Motion $motion): View
    {
        //todo policy
        $response = $this->authorize('update', [Auth::user(), $motion]);
      //  $this->authorize('update', Motion::class);

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

        //todo policy Admin  allowed
       // $response = $this->authorize('update', $motion);

        $response = Gate::inspect('update', $motion);
        if ($response->denied()) {
            return back()->with('error', $response->message());
        }

        $motion->fill($request->validated()['motion']);
        $motion->save();

        $result = $this->attachmentService->updateAttachment($request, $motion);

        if (null !== ($request->file('attachments'))) {
            $result = $this->attachmentService->createAttachment($request, $motion);
            if ($result) {
                Session::flash('success', 'You uploaded '.count($request->file('attachments')).' files');
            } else {
                Session::flash('error', 'You have an upload problem');
            }
        }
        $motion->load('attachments', 'user');
        //todo mail updates?

        //todo send email to execs and user and mals to say motion has been submitted

        /**
         * send to executive
         * send to member
         */

        $cc = Auth::user()->email;

        $motion->name = Auth::user()->name;
        $motion->email = Auth::user()->email;
        $motion->mail_subject = $motion->subject;
        $motion->mail_body = $motion->description;

        //todo motion template
        //todo email_message.blade
        //todo send to exec, author

        Mail::send('emails.contact', ['data' => $motion],
            function ($m) use ($motion, $cc) {
                $m->from(config('mail.from.address'), config('app.name'). ' ' .  $motion->submission_type . ' updated by'. Auth::user()->name);
                $m->to(config('mail.executive.address'), config('mail.executive.name'));
                $m->cc($cc, $cc);
                $m->replyTo(Auth::user()->email ,Auth::user()->name);

                $m->subject(" Motions & New Business Submission from " . Auth::user()->name . ": " . $motion->title);
                if ($motion->attachments->count() > 0) {
                    foreach ($motion->attachments as $att) {
                        $file = 'storage/motions/' . $att->file;
                        $mime = mime_content_type(getcwd() . "/" . $file);
                        $file_name = $att->file_name;
                        $m->attach($file, ['as' => $file_name, 'mime' => $mime]);
                    }
                }
                Session::flash('success', 'Message Sent');
            });

        $al = new ActivityLog([
            'activity' => "Admin Edit to ".
                $motion->submission_type . ": " .
                Auth::user()->name . ' updated a ' .
                $motion->submission_type . ' ' .
                $motion->title .', created by: '.
                $motion->user->name,
            'ip_address' => $_SERVER['REMOTE_ADDR'],
            'user_agent' => $_SERVER['HTTP_USER_AGENT'],
            'model' => 'Admin']);

        $al->save();

        Session::flash('success', 'You have updated a motion or new business');
        return redirect()->route('admin_motion_edit', $motion->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DestroyMotionRequest $motion): RedirectResponse
    {
        //todo policy

        $this->authorize('delete', Motion::class);

        Motion::withoutGlobalScopes()
            ->find($motion->id)
            ->each(function (Motion $motion) {
                $this->attachmentService->destroyAttachments($motion);
                $motion->delete();
            });

        //todo message deletion

        Session::flash('success', Str::plural(count([$motion->id]).' Motion', count([$motion->id])).
            ' and any related files deleted.');

        return redirect()->route('admin_motions_list');

    }
}
