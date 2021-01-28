<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class MeetingController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        //todo turn years data for menu into service using year, table name
        // gets the years in this table  $table $date_column
        $years = DB::table('meetings')
            ->select(DB::raw('DISTINCT YEAR(date) as year'))
            ->orderBy('year', 'asc')
            ->get();

        $data = [
            'meetings' => Meeting::withoutGlobalScopes()
                ->sortable()->with('user')->orderBy('date', 'desc')->paginate(20),
            'count' => Meeting::withoutGlobalScopes()->count(),
            'years' => $years,
            'year' => '',
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
            ->orderBy('year', 'asc')
            ->get();


        $meetings = Meeting::withoutGlobalScopes()
            ->sortable()
            ->whereBetween('date', [$year.'-01-01', $year.'-12-31'])
            ->with('user')
            ->orderBy('date', 'desc')
            ->paginate(10);

        $data = [
            'meetings' => $meetings,
            'count' => $meetings->count(),
            'years' => $years,
            'year' => $year,
        ];

        return view('list_meetings_minutes', ['data' => $data]);
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
