<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Meetings\DestroyMeetingRequest;
use App\Http\Requests\Meetings\StoreMeetingRequest;
use App\Http\Requests\Meetings\UpdateMeetingRequest;
use App\Models\Meeting;
use App\Models\Message;
use App\Models\Options;
use App\Services\AttachmentService;
use App\Services\FeatureService;
use App\Services\MessageService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
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

        return view(
            'admin.meeting',
            [
                'data' => [
                    'meeting' => $meeting,
                    'action' => 'Add',
                    'access_levels' => Options::access_levels(),
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

        $meeting = new Meeting($request->meeting);

        $meeting->save();

        Session::flash('success', 'Meeting saved');

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

        $meeting->load('user', 'attachments');

        return view(
            'admin.meeting',
            [
                'data' => [
                    'meeting' => $meeting,
                    'action' => 'Edit',
                    'existing_message' => Message::where('source_url',  env('APP_URL') . '/meeting/' . $meeting->id)->exists(),
                    'access_levels' => Options::access_levels(),
                ],
            ]
        );
    }

    /**
     * @throws AuthorizationException
     */
    public function update(UpdateMeetingRequest $request, Meeting $any_meeting): RedirectResponse
    {
        $this->authorize('update', Meeting::class);

        $any_meeting->fill($request->meeting);
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

        Session::flash('success', 'new message from posts saved');

        return redirect()->route('admin_message_edit', [$msg->id, $msg->slug]);
    }

    public function feature(Meeting $meeting): RedirectResponse
    {
        $this->authorize('update', Meeting::class);
        $meeting->source_url = env('APP_URL') . '/minutes/' . $meeting->id;
        $msg = $this->featureService->createMeetingFeature($meeting);
        Session::flash('success', 'new feature from Meeting Minutes saved');
        return redirect()->route('admin_feature_edit', [$msg->slug]);
    }

}
