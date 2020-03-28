<?php

namespace App\Http\Controllers;

use App\Http\Requests\Meetings\DestroyMeetingRequest;
use App\Http\Requests\Meetings\StoreMeetingRequest;
use App\Http\Requests\Meetings\UpdateMeetingRequest;
use App\Models\Meeting;
use App\Services\AttachmentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;


class AdminMeetingController extends Controller
{
    /**
     * @var AttachmentService
     */
    private $attachmentService;

    public function __construct(AttachmentService $attachmentService)
    {
        $this->attachmentService = $attachmentService;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('viewAny', Auth::user());

        $data = [];
        $data['meetings'] = Meeting::withoutGlobalScopes()->sortable()->with('user', 'attachments')->orderBy('date', 'desc')->paginate(20);
        $data['count'] = Meeting::withoutGlobalScopes()->count();

        return view('admin.listmeetings', ['data' => $data]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Auth::user());
        $meeting = new Meeting();
        $meeting->live = 1;

        return view('admin.meeting', ['data' => [
            'meeting' => $meeting,
            'action' => 'Add',
            ]]);
    }


    /**
     * @param StoreMeetingRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreMeetingRequest $request)
    {
        $this->authorize('create', Auth::user());

        $meeting = new Meeting($request->input('meeting'));
        $meeting->user_id = Auth::id();
        $meeting->save();

        Session::flash('success', "Meeting saved");

        if (null !== ($request->file('attachments')))
        {
            $result = $this->attachmentService->createAttachment($request, $meeting);

            if($result){
                Session::flash('success', "You uploaded " . count($request->file('attachments')) . " files");
            }
            else
            {
                Session::flash('error', "You have an upload problem");
            }
        }

        return redirect()->route('meeting_edit', [$meeting->id]);
    }

    /**
     * @param Meeting $meeting
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Meeting $meeting)
    {
        $this->authorize('update', Auth::user());

        $meeting->load('user', 'attachments');

        return view('admin.meeting', ['data' => [
            'meeting' => $meeting,
            'action' => 'Edit',
            ]]);
    }


    /**
     * @param UpdateMeetingRequest $request
     * @param Meeting $meeting
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateMeetingRequest $request, Meeting $any_meeting): RedirectResponse
    {
        $this->authorize('update', Auth::user());

        $any_meeting->fill($request['meeting']);
        $any_meeting->save();

        $result = $this->attachmentService->updateAttachment($request, $any_meeting);

        if (null !== ($request->file('attachments')))
        {
            $result = $this->attachmentService->createAttachment($request, $any_meeting);

            if($result){
                Session::flash('success', "You uploaded " . count($request->file('attachments')) . " files");
            }
            else
            {
                Session::flash('error', "You have an upload problem");
            }
        }

        Session::flash('success', "You have edited the meeting information");

        return redirect()->route('meeting_edit', [$any_meeting->id]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(DestroyMeetingRequest $request)
    {
        $this->authorize('delete', Auth::user());
        Meeting::withoutGlobalScopes()
            ->find($request->id)
            ->each(function(Meeting $meeting) {
                $this->attachmentService->destroyAttachments($meeting);
                $meeting->delete();
            });

        Session::flash('success', Str::plural(count($request->id) . ' Meeting', count($request->id)) . ' and any related files deleted.');

        return redirect()->route('meetings_list');
    }
}
