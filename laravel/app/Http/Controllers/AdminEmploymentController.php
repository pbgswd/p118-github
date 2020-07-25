<?php

namespace App\Http\Controllers;

use App\Http\Requests\Employment\DestroyEmploymentRequest;
use App\Http\Requests\Employment\StoreEmploymentRequest;
use App\Http\Requests\Employment\UpdateEmploymentRequest;
use App\Models\Employment;
use App\Services\AttachmentService;
use Illuminate\Http\RedirectResponse;
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
        $jobs = Employment::withoutGlobalScopes()
            ->sortable()
            ->with('attachments')
            ->orderBy('deadline', 'desc')
            ->paginate(20);

        foreach($jobs as $job)
        {
            $job['jobstatus'] = $job->deadline->isPast() ? 0 : 1;
        }

        $data['employment'] = $jobs;
        $data['count'] = Employment::withoutGlobalScopes()->count();

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
     * @param StoreEmploymentRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreEmploymentRequest $request)
    {
        $this->authorize('create', Auth::user());
        $employment = new Employment($request->employment);

        $employment->save();

        if (null !== ($request->file('attachments'))){
            $result = $this->attachmentService->createAttachment($request, $employment);

            if($result){
                Session::flash('success', "You uploaded " . count($request->file('attachments')) . " files");
            }
            else
            {
                Session::flash('error', "You have an upload problem");
            }
        }

        Session::flash('success', "employment posting saved");
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

        $employment['jobstatus'] = $employment->deadline->isPast() ? 0 : 1;

        return view(
            'admin.employment',
            [
                'data' => [
                    'employment' => $employment,
                    'action' => 'Edit',
                ],
            ]
        );
    }

    /**
     * @param UpdateEmploymentRequest $request
     * @param Employment $any_employment
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateEmploymentRequest $request, Employment $any_employment): RedirectResponse
    {
        $this->authorize('update', Auth::user());

        $any_employment->fill($request->employment);

        $any_employment->save();

        $result = $this->attachmentService->updateAttachment($request, $any_employment);

        if (null !== ($request->file('attachments'))) {
            $result = $this->attachmentService->createAttachment($request, $any_employment);

            if($result) {
                Session::flash('success', "You uploaded " . count($request->file('attachments')) . " files");
            }
            else
            {
                Session::flash('error', "You have an upload problem");
            }
        }

        Session::flash('success', "You have edited the employment information");

        return redirect()->route('admin_employment_edit', [$any_employment->id]);
    }

    /**
     * @param DestroyEmploymentRequest $request
     * @return RedirectResponse
     */
    public function destroy(DestroyEmploymentRequest $request)
    {
        $this->authorize('delete', Auth::user());

        Employment::withoutGlobalScopes()
            ->find($request->id)
            ->each(function (Employment $employment) {
               $this->attachmentService->destroyAttachments($employment);
               $employment->delete();
            });

        Session::flash('success', Str::plural(count($request->id) . ' posting', count($request->id)) . ' and any related files deleted.');

        return redirect()->route('employment_list');
    }
}
