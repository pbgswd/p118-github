<?php

namespace App\Http\Controllers;

use App\Http\Requests\Meetings\QueryMeetingYearRequest;
use App\Models\Meeting;
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

        $data = [
            'meetings' => $meetings,
            'count' => $count,
            'years' => $years,
            'year' => '',
            'pagination' => $pagination,
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

        $data = [
            'meetings' => $meetings,
            'count' => $count,
            'years' => $years,
            'year' => $year,
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
        $meeting->load('user', 'attachments');
        return view('meeting', ['data' => ['meeting' => $meeting,
            'year' => session('year', '')]
        ]);
    }
}
