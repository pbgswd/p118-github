<?php

namespace App\Http\Controllers;

use App\Http\Requests\Meetings\QueryMeetingYearRequest;
use App\Models\Meeting;
use App\Models\Motion;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class MeetingController extends Controller
{
    public function index(): View
    {
        $pagination = 30;
        session()->forget('year');

        $years = DB::table('meetings')
            ->select(DB::raw('DISTINCT YEAR(date) as year'))
            ->orderBy('year', 'desc')
            ->get();

        $meetings = Meeting::withoutGlobalScopes()
            ->where('live', 1)
            ->sortable()
            ->with('user')
            ->orderBy('date', 'desc')
            ->paginate($pagination);

        $count = Meeting::withoutGlobalScopes()->count();

        $upcoming = Meeting::withoutGlobalScopes()
            ->where('live', 1)
            ->where('date', '>=', date('Y-m-d'))
            ->withCount('motions')
            ->orderBy('date', 'asc')
            ->get();



        $newmotions = Motion::where('meeting_id', null)->with('user')->get();

        $data = [
            'meetings' => $meetings,
            'count' => $count,
            'years' => $years,
            'year' => '',
            'pagination' => $pagination,
            'title' => 'Meetings, Minutes, Documents, Motions, New Business',
            'upcoming' => $upcoming,
            'newmotions' => $newmotions,
            'action' => 'Create',
        ];

        return view('list_meetings_minutes', ['data' => $data]);
    }

    public function index_by_year($year): View
    {
        $years = DB::table('meetings')
            ->select(DB::raw('DISTINCT YEAR(date) as year'))
            ->orderBy('year', 'desc')
            ->get();

        $meetings = Meeting::withoutGlobalScopes()
            ->where('live', 1)
            ->sortable()
            ->whereBetween('date', [$year.'-01-01', $year.'-12-31'])
            ->with('user')
            ->orderBy('date', 'desc')
            ->paginate(1000);

        $count = Meeting::withoutGlobalScopes()
            ->whereBetween('date', [$year.'-01-01', $year.'-12-31'])->count();

        $upcoming = Meeting::withoutGlobalScopes()
            ->where('live', 1)
            ->where('date', '>=', now())
            ->orderBy('date', 'asc')
            ->get();

        $meeting = Meeting::where([['meeting_type', '=', 'General'], ['live', '=',  1], ['date', '>', now()]])
            ->orderBy('date', 'asc')
            ->first();

        $data = [
            'meetings' => $meetings,
            'count' => $count,
            'years' => $years,
            'year' => $year,
            'upcoming' => $upcoming,
            'title' => $year.' Meetings',
            'newmotions' => [],

        ];

        return view('list_meetings_minutes', ['data' => $data]);
    }

    public function post_year(QueryMeetingYearRequest $request): RedirectResponse
    {
        session(['year' => $request->year]);

        return redirect()->route('list_meetings_year', $request->year);
    }

    public function show(Meeting $meeting): View
    {
        $meeting->load('user', 'attachments', 'motions');
        $meeting->motions->load('user');

        $next = Meeting::where('id', '>', $meeting->id)
            ->where('live', 1)
            ->orderBy('id', 'asc')
            ->first();

        $previous = Meeting::where('id', '<', $meeting->id)
            ->where('live', 1)
            ->orderBy('id', 'desc')
            ->first();

        $upcoming = Meeting::withoutGlobalScopes()
            ->where('live', 1)
            ->where('date', '>=', date('Y-m-d'))
            ->withCount('motions')
            ->orderBy('date', 'asc')
            ->get();

        $data = [
            'meeting' => $meeting,
            'year' => session('year', ''),
            'title' => $meeting->title,
            'next' => $next,
            'upcoming' => $upcoming,
            'previous' => $previous,
            'action' => 'Create',
        ];

        return view('meeting', ['data' => $data]);
    }
}
