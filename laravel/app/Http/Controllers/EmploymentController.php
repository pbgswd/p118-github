<?php

namespace App\Http\Controllers;

use App\Models\Employment;
use App\Services\AttachmentService;
use Illuminate\Http\Response;

class EmploymentController extends Controller
{
    /** @var AttachmentService */
    private $attachmentService;

    public function __construct(AttachmentService $attachmentService)
    {
        $this->attachmentService = $attachmentService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data = [];
        $jobs = Employment::sortable()
            ->where('live', '=', 1)
            ->with('attachments')
            ->orderBy('deadline', 'desc')
            ->paginate(20);

        foreach ($jobs as $job) {
            $job['jobstatus'] = $job->deadline->isPast() ? 0 : 1;
        }

        $data['employment'] = $jobs;
        $data['count'] = Employment::count();

        return view('employment_list', ['data' => $data]);
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
