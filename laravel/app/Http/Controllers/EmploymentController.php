<?php

namespace App\Http\Controllers;

use App\Http\Requests\Employment\QueryJobYearRequest;
use App\Models\Employment;
use App\Services\AttachmentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class EmploymentController extends Controller
{
    /** @var AttachmentService */
    private $attachmentService;

    public function __construct(AttachmentService $attachmentService)
    {
        $this->attachmentService = $attachmentService;
    }

    /**
     * @return View
     */
    public function index(): View
    {
        //todo update job status on page load

        // update status set status = 0

        $data = [];

        $years = DB::table('employment')
            ->select(DB::raw('DISTINCT YEAR(deadline) as year'))
            ->orderBy('year', 'desc')
            ->get();

        $jobs = Employment::sortable()
            ->where('live', '=', 1)
            ->with('attachments')
            ->orderBy('deadline', 'desc')
            ->paginate(20);

        foreach ($jobs as $job) {
            //todo update job status on page load
            $job['jobstatus'] = $job->deadline->isPast() ? 0 : 1;
        }

        $data['employment'] = $jobs;
        $data['years'] = $years;
        $data['year'] = '';
        $data['count'] = Employment::count();

        return view('employment_list', ['data' => $data]);
    }


    /**
     * @param $year
     * @return View
     */
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
            ->paginate(10);

        $jobs_count =  Employment::where('live', '=', 1)
            ->whereBetween('deadline', [$year.'-01-01', $year.'-12-31'])->get();

        foreach ($jobs as $job) {
            $job['jobstatus'] = $job->deadline->isPast() ? 0 : 1;
        }

        $data = [
            'employment' => $jobs,
            'count' => $jobs_count->count(),
            'years' => $years,
            'year' => $year,
        ];

        return view('employment_list', ['data' => $data]);
    }

    /**
     * @param QueryJobYearRequest $request
     * @return RedirectResponse
     */
    public function jobs_year(QueryJobYearRequest $request): RedirectResponse
    {
        return redirect()->route('list_jobs_year', $request->deadline);
    }














    /**
     * Display the specified resource.
     *
     * @param Employment $employment
     * @return Response
     */
    public function show(Employment $employment)
    {
        $employment->load('user', 'attachments');

        $employment['jobstatus'] = $employment->deadline->isPast() ? 0 : 1;

        return view('employment', ['data' => ['employment' => $employment]]);
    }
}
