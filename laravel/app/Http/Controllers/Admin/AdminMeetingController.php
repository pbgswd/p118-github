<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Meetings\DestroyMeetingRequest;
use App\Http\Requests\Meetings\StoreMeetingRequest;
use App\Http\Requests\Meetings\UpdateMeetingRequest;
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

        $data = [];
        $data['meetings'] = Meeting::withoutGlobalScopes()
            ->sortable()
            ->with('user', 'attachments')
            ->orderBy('date', 'desc')
            ->paginate(20);

        $data['count'] = Meeting::withoutGlobalScopes()->count();

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


        //todo data count of motions that are not attached to a meeting to be attached to this meeting

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

        //attach any orphan motions to this meeting

           if($meeting->meeting_type == 'General') {
               $motions = Motion::where('meeting_id', null)->get();
               $savedcount = intval(0);
               foreach ($motions as $motion) {
                   $motion->meeting_id = $meeting->id;
                   if((Carbon::today()->diffInDays($motion->date)-10) > 0) {
                       $motion->save();
                       $savedcount++;
                       //todo send email to executive with new attached motion
                   }
               }

               $flash_motion_msg = Str::of('submission')->plural($savedcount) . ' attached to meeting';
           }

        //todo setup flash message for motions attached to meeting
        Session::flash('success', 'Meeting saved. '.$flash_motion_msg ?? '');

        if (null !== ($request->file('attachments'))) {
            $result = $this->attachmentService->createAttachment($request, $meeting);

            if ($result) {
                Session::flash('success', 'You uploaded '.
                    count([$request->file('attachments')]).' files');
            } else {
                Session::flash('error', 'You have an upload problem');
            }
        }

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

        $now = Carbon::now();
        $date_in_ten = $now->addDays(10);

        $any_meeting->date = new \DateTime($data['meeting']['date'].' '.$data['meeting']['time']);

        //dd($any_meeting->isDirty('date'));
//dd($data['meeting']['date']);
        $datefromsubmission = Carbon::createFromFormat('Y-m-d', $data['meeting']['date']);

       // dd($datefromsubmission->format('Y-m-d'));
        //todo only if the date was changed and less than 10 days away, detach motions from meeting
        if($any_meeting->isDirty('date') && $any_meeting->date < $date_in_ten) {
            // what if I am just updating the content of the meeting, the date hasnt changed?
          // Motion::Where('meeting_id', $any_meeting->id)->update(['meeting_id' => null]);
            dd('date changed, less than 10 days away');
        }
        //todo what if you update the meeting date and it is now has 10 days, do you allow the new motions to be attached to the meeting?
        $any_meeting->save();

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

        return redirect()->route('meeting_edit', [$any_meeting->id]);
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy(DestroyMeetingRequest $request): RedirectResponse
    {
        $this->authorize('delete', Meeting::class);
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
