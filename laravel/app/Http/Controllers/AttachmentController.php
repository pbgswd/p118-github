<?php

namespace App\Http\Controllers;

use App\Http\Requests\Attachments\DestroyAttachment;
use App\Http\Requests\Attachments\StoreAttachment;
use App\Http\Requests\Attachments\UpdateAttachment;
use App\Models\Attachment;
use DB;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
//use Illuminate\Support\Facades\Storage;
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

        return view('admin.attachment', ['data' => ['attachment' => $attachment, 'action' => 'Add']]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAttachment $request)
    {
        $this->uploadImages($request);

        foreach ($request->images as $image)
        {
            $attachment = new Attachment($request->input('attachment'));
            $attachment['name'] = $image;
            $attachment['user_id'] = Auth::id();
            $attachment->save();
        }
/*
        // get the date, month, year, make folder if not exist for storing stuff.
*/
        return redirect()->route('attachment_edit', [$attachment->slug]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Attachment  $attachment
     * @return \Illuminate\Http\Response
     */
    public function show(Attachment $attachment)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Attachment  $attachment
     * @return \Illuminate\Http\Response
     */
    public function edit(Attachment $attachment)
    {
        return view('admin.attachment', ['data' => ['attachment' => $attachment, 'action' => 'Edit']]);
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

        return view('admin.attachment', ['data' => ['attachment' => $attachment, 'action' => 'Edit']]);
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

    protected function uploadImages(FormRequest $request)
    {

        if (!$request->images) {
            return null;
        }
        foreach ($request->images as $k => $v) {

           // $imageName = $request->images[$k]->getClientOriginalName();

            if (!$request->images[$k]->storeAs('public', $request->images[$k])) {
                Session::flash('warning', "Did not store " . $v);
                return null;
            }
        }
        return $v;
    }
}
