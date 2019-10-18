<?php

namespace App\Http\Controllers;

use App\Http\Requests\Attachments\DestroyAttachment;
use App\Http\Requests\Attachments\StoreAttachment;
use App\Http\Requests\Attachments\UpdateAttachment;
use App\Models\Attachment;
use DB;
use Illuminate\Support\Facades\Auth;
use Session;
use Storage;
use Validator;

class AttachmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(\App\Models\Attachment $attachment)
    {
        $data = [];
        $data['attachments'] = Attachment::orderBy('id', 'ASC')->paginate(20);

        return view('admin.listattachments', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $attachment = new Attachment;
        $attachment['user_id'] = Auth::id();

        return view('admin.attachment', ['data'=> ['attachments' => $attachment, 'action' => 'Add']]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAttachment $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Attachment  $attachment
     * @return \Illuminate\Http\Response
     */
    public function show(Attachment $attachment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Attachment  $attachment
     * @return \Illuminate\Http\Response
     */
    public function edit(Attachment $attachment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Attachment  $attachment
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAttachment $request, Attachment $attachment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Attachment  $attachment
     * @return \Illuminate\Http\Response
     */
    public function destroy(DestroyAttachment $attachment)
    {
        //
    }
}
