<?php

namespace App\Http\Controllers;

use App\Models\Employment;
use App\Services\AttachmentService;


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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [];
        $data['employment'] = Employment::sortable()
            ->where('live', '=', 1)
            ->with('attachments')
            ->orderBy('deadline', 'desc')
            ->paginate(20);

        $data['count'] = Employment::count();
//todo use deadline to calculate status check or x
        return view('employment_list', ['data' => $data]);
    }



    /**
     * Display the specified resource.
     *
     * @param \App\Models\Employment $employment
     * @return \Illuminate\Http\Response
     */
    public function show(Employment $employment)
    {
        $employment->load('user', 'attachments');

        return view('employment', ['data' => ['employment' => $employment]]);
    }



}
