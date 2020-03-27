<?php

namespace App\Http\Controllers;

use App\Http\Requests\Agreements\DestroyAgreementRequest;
use App\Http\Requests\Agreements\StoreAgreementRequest;
use App\Http\Requests\Agreements\UpdateAgreementRequest;
use App\Models\Agreement;
use App\Services\AttachmentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class AgreementController extends Controller
{
    /** @var AttachmentService  */
    private $attachmentService;

    /**
     * AgreementController constructor.
     * @param AttachmentService $attachmentService
     */
    public function __construct(AttachmentService $attachmentService)
    {
        $this->attachmentService = $attachmentService;
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function list()
    {
        //$this->authorize('viewAny', Auth::user());

        $data['agreements'] = Agreement::sortable()->where('live', '1')->with('attachments')->orderBy('until', 'desc')->paginate(20);
        $data['count'] = Agreement::count();

        return view('agreements_list', ['data' => ['data' => $data]]);
    }


    /**
     * Display the specified resource.
     * @param Agreement $agreement
     * @return Response
     */
    public function show(Agreement $agreement)
    {
        $agreement->load('user', 'attachments');

        return view('agreement_view', ['data' => ['agreement' => $agreement]]);
    }

}
