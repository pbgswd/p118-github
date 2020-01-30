<?php

namespace App\Http\Controllers;

use App\Models\Employment;
use App\Services\AttachmentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class EmploymentController extends Controller
{
    /** @var AttachmentService*/
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
        $data['employment'] = Employment::sortable()->orderBy('deadline', 'desc')->paginate(20);
        $data['count'] = count(Employment::all());

        return view('admin.employment_list', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $e = new Employment;
        return view('admin.employment', ['data' => ['employment' => $e, 'action' => 'Add']]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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

        return redirect()->route('employment_edit', [$employment->id]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employment  $employment
     * @return \Illuminate\Http\Response
     */
    public function show(Employment $employment)
    {
        //todo delete show method if not needed
        echo __METHOD__;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employment  $employment
     * @return \Illuminate\Http\Response
     */
    public function edit(Employment $employment)
    {
        $employment->load('user', 'attachments');

        return view('admin.employment', ['data' => ['employment' => $employment, 'action' => 'Edit']]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employment  $employment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employment $employment)
    {
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

        return redirect()->route('employment_edit', [$employment->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employment  $employment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $employments = Employment::find($request->id);

        foreach($employments as $employment)
        {
            $result = $this->attachmentService->destroyAttachment($employment);

            Employment::destroy($employment->id);
        }

        Session::flash('success', Str::plural(count($request->id) . ' posting', count($request->id)) . ' and any related files deleted.');

        return redirect()->route('employment_list');
    }
}
