<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Motions\DestroyMotionRequest;
use App\Http\Requests\Motions\StoreMotionRequest;
use App\Http\Requests\Motions\UpdateMotionRequest;
use App\Models\Meeting;
use App\Models\Motion;
use App\Models\Options;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminMotionController extends Controller
{
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
        //todo show create motion form
        //todo indicate next general meetings date
        //todo 10 days rule
        //attach to next general meeting
        $data = [
            'motion' => new Motion(),
            'motion_types' => Options::motion_types(),
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

        //todo send email to execs and user and mals to say motion has been submitted

        Session::flash('success', 'You have submitted a ' . $motion->submission_type . ' successfully. It will be reviewed by the Executive.');

        return redirect()->route('list_meetings');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Motion $motion)
    {
        dd($motion);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMotionRequest $request, Motion $motion)
    {
        dd($motion);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DestroyMotionRequest $motion): RedirectResponse
    {

      //  $this->authorize('delete', Motion::class);
        Motion::withoutGlobalScopes()
            ->find($motion->id)
            ->each(function (Motion $motion) {
               // $this->attachmentService->destroyAttachments($motion);
                $motion->delete();
            });

        Session::flash('success', Str::plural(count([$motion->id]).' Motion', count([$motion->id])).
            ' and any related files deleted.');

        return redirect()->route('admin_motions_list');

    }
}
