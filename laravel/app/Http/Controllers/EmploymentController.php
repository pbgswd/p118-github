<?php

namespace App\Http\Controllers;

use App\Http\Requests\Employment\QueryJobYearRequest;
use App\Models\Employment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class EmploymentController extends Controller
{
    public function __construct()
    {
        // Artisan::call('employment:update-status');
    }

    public function index(): View
    {
        session()->forget('year');

        $years = DB::table('employment')
            ->select(DB::raw('DISTINCT YEAR(deadline) as year'))
            ->orderBy('year', 'desc')
            ->get();

        $jobs = Employment::sortable()
            ->where('live', '=', 1)
            ->with('attachments')
            ->orderBy('deadline', 'desc')
            ->paginate(30);

        $data = [
            'employment' => $jobs,
            'years' => $years,
            'year' => '',
            'count' => Employment::count(),
            'title' => 'Employment Postings',
        ];

        return view('employment_list', ['data' => $data]);
    }

    public function index_by_year($year): View
    {
        $years = DB::table('employment')
            ->select(DB::raw('DISTINCT YEAR(deadline) as year'))
            ->orderBy('year', 'desc')
            ->get();

        $jobs = Employment::sortable()
            ->where('live', '=', 1)
            ->whereBetween('deadline', [$year.'-01-01', $year.'-12-31'])
            ->orderBy('deadline', 'asc')
            ->paginate(1000);

        $jobs_count = Employment::where('live', '=', 1)
            ->whereBetween('deadline', [$year.'-01-01', $year.'-12-31'])->get();

        foreach ($jobs as $job) {
            $job['jobstatus'] = $job->deadline->isPast() ? 0 : 1;
        }

        $data = [
            'employment' => $jobs,
            'count' => $jobs_count->count(),
            'years' => $years,
            'year' => $year,
            'title' => $year.' Employment Postings',
        ];

        return view('employment_list', ['data' => $data]);
    }

    public function jobs_year(QueryJobYearRequest $request): RedirectResponse
    {
        session(['year' => $request->year]);

        return redirect()->route('list_jobs_year', $request->year);
    }

    /**
     * Display the specified resource.
     */
    public function show(Employment $employment): View
    {
        $employment->load('user', 'attachments');

        $next = Employment::where('id', '>', $employment->id)
            ->where('live', 1)
            ->orderBy('id', 'asc')
            ->first();

        $previous = Employment::where('id', '<', $employment->id)
            ->where('live', 1)
            ->orderBy('id', 'desc')
            ->first();

        return view('employment', [
            'data' => [
                'employment' => $employment,
                'year' => session('year', ''),
                'title' => $employment->title.' - Employment Posting',
                'next' => $next,
                'previous' => $previous,

            ],
        ]);
    }
}
