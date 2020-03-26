<?php

namespace App\Http\Controllers;

use App\Models\Employment;
use App\Services\AttachmentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;


class AdminEmploymentController extends Controller
{
    /** @var AttachmentService */
    private $attachmentService;

    public function __construct(AttachmentService $attachmentService)
    {
        $this->attachmentService = $attachmentService;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('viewAny', Auth::user());

        $data = [];
        $data['employment'] = Employment::sortable()->with('attachments')->orderBy('deadline', 'desc')->paginate(20);
        $data['count'] = count(Employment::all());

        return view('admin.employment_list', ['data' => $data]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Auth::user());
        $e = new Employment;
        return view('admin.employment', ['data' => ['employment' => $e, 'action' => 'Add']]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request)
    {
        $this->authorize('create', Auth::user());
        $employment = new Employment($request->input('employment'));
        $employment->user_id = Auth::id();
        $employment->save();

        Session::flash('success', "employment posting saved");

        if (null !== ($request->file('attachments')))
        {
            $result = $this->attachmentService->createAttachment($request, $employment);

            if($result){
                Session::flash('success', "You uploaded " . count($request->file('attachments')) . " files");
            }
            else
            {
                Session::flash('error', "You have an upload problem");
            }
        }

        return redirect()->route('admin_employment_edit', [$employment->id]);

    }

    /**
     * @param Employment $employment
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Employment $employment)
    {
        $this->authorize('update', Auth::user());
        $employment->load('user', 'attachments');

        return view('admin.employment', ['data' => ['employment' => $employment, 'action' => 'Edit']]);
    }

    /**
     * @param Request $request
     * @param Employment $employment
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, Employment $employment)
    {
        $this->authorize('update', Auth::user());
        $employment->fill($request['employment']);
        $employment->save();

        $result = $this->attachmentService->updateAttachment($request, $employment);

        if (null !== ($request->file('attachments')))
        {
            $result = $this->attachmentService->createAttachment($request, $employment);

            if($result){
                Session::flash('success', "You uploaded " . count($request->file('attachments')) . " files");
            }
            else
            {
                Session::flash('error', "You have an upload problem");
            }
        }

        Session::flash('success', "You have edited the employment information");

        return redirect()->route('admin_employment_edit', [$employment->id]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Request $request)
    {
        $this->authorize('delete', Auth::user());
        $employments = Employment::find($request->id);

        foreach($employments as $employment)
        {
            $result = $this->attachmentService->destroyAttachments($employment);

            Employment::destroy($employment->id);
        }

        Session::flash('success', Str::plural(count($request->id) . ' posting', count($request->id)) . ' and any related files deleted.');

        return redirect()->route('employment_list');
    }
}
