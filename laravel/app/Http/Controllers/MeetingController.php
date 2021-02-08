<?php

namespace App\Http\Controllers;

use App\Http\Requests\Meetings\QueryMeetingYearRequest;
use App\Models\Meeting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class MeetingController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        $pagination = 10;

        $years = DB::table('meetings')
            ->select(DB::raw('DISTINCT YEAR(date) as year'))
            ->orderBy('year', 'desc')
            ->get();

        $meetings = Meeting::withoutGlobalScopes()
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

    /**
     * @param $year
     * @return View
     */
    public function index_by_year($year): View
    {
        $years = DB::table('meetings')
            ->select(DB::raw('DISTINCT YEAR(date) as year'))
            ->orderBy('year', 'desc')
            ->get();

        $meetings = Meeting::withoutGlobalScopes()
            ->sortable()
            ->whereBetween('date', [$year.'-01-01', $year.'-12-31'])
            ->with('user')
            ->orderBy('date', 'desc')
            ->paginate(10);

        $count = Meeting::withoutGlobalScopes()->whereBetween('date', [$year.'-01-01', $year.'-12-31'])->count();

        $data = [
            'meetings' => $meetings,
            'count' => $count,
            'years' => $years,
            'year' => $year,
        ];

        return view('list_meetings_minutes', ['data' => $data]);
    }

    /**
     * @param QueryMeetingYearRequest $request
     * @return RedirectResponse
     */
    public function post_year(QueryMeetingYearRequest $request): RedirectResponse
    {
        return redirect()->route('list_meetings_year', $request->year);
    }


    /**
     * @param Meeting $meeting
     * @return View
     */
    public function show(Meeting $meeting): View
    {
        $meeting->load('user', 'attachments');

        return view('meeting', ['data' => ['meeting' => $meeting]]);
    }
}
