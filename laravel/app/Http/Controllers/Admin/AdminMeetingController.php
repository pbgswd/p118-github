<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Meetings\DestroyMeetingRequest;
use App\Http\Requests\Meetings\StoreMeetingRequest;
use App\Http\Requests\Meetings\UpdateMeetingRequest;
use App\Models\ActivityLog;
use App\Models\Meeting;
use App\Models\Message;
use App\Models\Motion;
use App\Models\Options;
use App\Services\AttachmentService;
use App\Services\FeatureService;
use App\Services\MessageService;
use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminMeetingController extends Controller
{
    /**
     * @var AttachmentService
     */
    private AttachmentService $attachmentService;
    private MessageService $messageService;
    private FeatureService $featureService;
    public function __construct(AttachmentService $attachmentService, MessageService $messageService, FeatureService $featureService)
    {
        $this->attachmentService = $attachmentService;
        $this->messageService = $messageService;
        $this->featureService = $featureService;
    }

    /**
     * @throws AuthorizationException
     */
    public function index(): View
    {
        $this->authorize('viewAny', Meeting::class);

        $meetings = Meeting::withoutGlobalScopes()
            ->sortable()
            ->with('user', 'attachments', 'motions')
            ->orderBy('date', 'desc')
            ->paginate(20);

        $data = [
            'meetings' => $meetings,
            'count' => Meeting::withoutGlobalScopes()->count(),
        ];

        return view('admin.listmeetings', ['data' => $data]);
    }

    /**
     * @throws AuthorizationException
     */
    public function create(): View
    {
        $this->authorize('create', Meeting::class);
        $meeting = new Meeting;
        $meeting->live = $meeting->getDefaultLiveStatus();

        Session::flash('info', 'New General Meetings will get any unattached New Motions and New Business when Status is set to live');

        return view(
            'admin.meeting',
            [
                'data' => [
                    'meeting' => $meeting,
                    'action' => 'Add',
                    'access_levels' => Options::access_levels(),
                    'meeting_types' => Options::meeting_types(),
                ],
            ]
        );
    }

    /**
     * @throws AuthorizationException
     */
    public function store(StoreMeetingRequest $request): RedirectResponse
    {
        $this->authorize('create', Meeting::class);
        $data = $request->validated();
        $meeting = new Meeting($data['meeting']);
        $meeting->date = new \DateTime($data['meeting']['date'].' '.$data['meeting']['time']);
        $meeting->user_id = Auth::user()->id;
        $meeting->save();

           if($meeting->meeting_type == 'General' && $meeting->live == 1) {
               $motions = Motion::where('meeting_id', null)->get();
               $savedcount = intval(0);
               foreach ($motions as $motion) {
                   // Motion
                   if(( Carbon::today()->diffInDays($meeting->date) - 10 ) > 0 && $motion->submission_type == 'Motion') {
                       $motion->meeting_id = $meeting->id;
                       $motion->save();
                       $savedcount++;
                       //todo send email to executive with new attached motion
                   }
                    // New Business
                   if(( Carbon::today()->diffInHours($meeting->date) - 48 ) > 0 && $motion->submission_type == 'New Business') {
                       $motion->meeting_id = $meeting->id;
                       $motion->save();
                       $savedcount++;
                       //todo send email to executive with new attached motion
                   }
               }
               if($savedcount > 0) {
                   Session::flash('info', $savedcount . " " . Str::of('motion')->plural($savedcount) .' added to the meeting.');
               }
           }

        Session::flash('success', 'Meeting saved.');

        if (null !== ($request->file('attachments'))) {
            $result = $this->attachmentService->createAttachment($request, $meeting);

            if ($result) {
                Session::flash('success', 'You uploaded '.
                    count([$request->file('attachments')]).' files');
            } else {
                Session::flash('error', 'You have an upload problem');
            }
        }

        //todo when a meeting has been created, and motions ahve been newly associated with a meeting, send an email


        $al = new ActivityLog([
            'activity' => Auth::user()->name . ' created a new meeting, ' . $meeting->title,
            'ip_address' => $_SERVER['REMOTE_ADDR'],
            'user_agent' => $_SERVER['HTTP_USER_AGENT'],
            'model' => 'Admin']);
        $al->save();

        return redirect()->route('meeting_edit', [$meeting->id]);
    }

    /**
     * @throws AuthorizationException
     */
    public function edit(Meeting $meeting): View
    {
        $this->authorize('update', Meeting::class);
        $meeting->load('user', 'motions', 'attachments');
        $meeting->motions->load('user');
        $meeting->time = $meeting->date->format('H:i');

        return view(
            'admin.meeting',
            [
                'data' => [
                    'meeting' => $meeting,
                    'action' => 'Edit',
                    'existing_message' => Message::where('source_url',  env('APP_URL') . '/meeting/' .
                        $meeting->id)->exists(),
                    'access_levels' => Options::access_levels(),
                    'meeting_types' => Options::meeting_types(),
                ],
            ]
        );
    }

    /**
     * @param UpdateMeetingRequest $request
     * @param Meeting $any_meeting
     * @return RedirectResponse
     * @throws AuthorizationException
     * @throws \DateMalformedStringException
     */
    public function update(UpdateMeetingRequest $request, Meeting $any_meeting): RedirectResponse
    {
        $this->authorize('update', Meeting::class);
        $data = $request->validated();
        $any_meeting->fill($data['meeting']);
        $any_meeting->save();

        if($any_meeting->meeting_type != 'General') {
            Motion::where('meeting_id', $any_meeting->id)->update(['meeting_id' => null]);
        }

        $result = $this->attachmentService->updateAttachment($request, $any_meeting);

        if (null !== ($request->file('attachments'))) {
            $result = $this->attachmentService->createAttachment($request, $any_meeting);
            if ($result) {
                Session::flash('success', 'You uploaded '.
                    count([$request->file('attachments')]).' files');
            } else {
                Session::flash('error', 'You have an upload problem');
            }
        }

        Session::flash('success', 'You have edited the meeting information');

        $al = new ActivityLog([
            'activity' => Auth::user()->name . ' updated a new meeting, ' . $any_meeting->title,
            'ip_address' => $_SERVER['REMOTE_ADDR'],
            'user_agent' => $_SERVER['HTTP_USER_AGENT'],
            'model' => 'Admin']);
        $al->save();

        return redirect()->route('meeting_edit', [$any_meeting->id]);
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy(DestroyMeetingRequest $request): RedirectResponse
    {
        $this->authorize('delete', Meeting::class);

        $al = new ActivityLog([
            'activity' => Auth::user()->name . ' deleted a meeting or meetings.',
            'ip_address' => $_SERVER['REMOTE_ADDR'],
            'user_agent' => $_SERVER['HTTP_USER_AGENT'],
            'model' => 'Admin']);
        $al->save();

        Meeting::withoutGlobalScopes()
            ->find($request->id)
            ->each(function (Meeting $meeting) {
                $this->attachmentService->destroyAttachments($meeting);
                Motion::where('meeting_id', $meeting->id)->update(['meeting_id' => null]);
                $meeting->delete();
            });

        Session::flash('success', Str::plural(count([$request->id]).' Meeting', count([$request->id])).
            ' and any related files deleted.');

        return redirect()->route('meetings_list');
    }

    /**
     * @throws AuthorizationException
     */
    public function message(Meeting $meeting): RedirectResponse
    {
        $this->authorize('update', Meeting::class);

        $source_url = env('APP_URL') . '/minutes/' . $meeting->id;

        if(Message::where('source_url',  $source_url)->exists()) {
            Session::flash('warning', 'A message from this content has already been created');
            return redirect()->route('meeting_edit', [$meeting->id]);
        }

        $meeting->load('user');
        $meeting->source_url = $source_url;

        $msg = $this->messageService->createMeetingMessage($meeting);

        //todo construct data for message for motions to be attached to meeting in the message

        Session::flash('success', 'new message from posts saved');

        return redirect()->route('admin_message_edit', [$msg->id, $msg->slug]);
    }

    public function feature(Meeting $meeting): RedirectResponse
    {
        $this->authorize('update', Meeting::class);
        $meeting->source_url = env('APP_URL') . '/minutes/' . $meeting->id;

        //todo construct data for feature for motions to be attached to meeting in the feature


        $msg = $this->featureService->createMeetingFeature($meeting);
        Session::flash('success', 'new feature from Meeting Minutes saved');
        return redirect()->route('admin_feature_edit', [$msg->slug]);
    }

}
