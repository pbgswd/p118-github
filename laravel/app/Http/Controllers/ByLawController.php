<?php

namespace App\Http\Controllers;

use App\Models\Bylaw;
use App\Services\AttachmentService;
use Illuminate\Support\Facades\Auth;

class ByLawController extends Controller
{
    /** @var AttachmentService  */
    private $attachmentService;

    /**
     * BylawController constructor.
     *
     * @param AttachmentService $attachmentService
     */
    public function __construct(AttachmentService $attachmentService)
    {
        $this->attachmentService = $attachmentService;
    }

    public function list()
    {
        $data = [];
        if(Auth::check()) {
        $data['bylaws'] = Bylaw::sortable()
            ->with('attachments')
            ->orderBy('date', 'desc')
            ->paginate(20);

        $data['count'] = Bylaw::count();
        }



        else {
        $data['bylaws'] = Bylaw::sortable()
            ->where('access_level', 'public')
            ->with('attachments')
            ->orderBy('date', 'desc')
            ->paginate(20);

        $data['count'] = Bylaw::where('access_level', 'public')->count();
        }



        return view('bylaws_list', ['data' => ['data' => $data]]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bylaw  $bylaw
     * @return \Illuminate\Http\Response
     */
    public function show(Bylaw $bylaw)
    {
        //todo bylaw checkbox members/public

        $bylaw->load('user', 'attachments');

        return view('bylaw_view', ['data' => ['bylaw' => $bylaw]]);
    }
}
