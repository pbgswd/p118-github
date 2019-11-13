<?php

namespace App\Http\Controllers;

use App\Http\Requests\Attachments\DestroyAttachment;
use App\Http\Requests\Attachments\StoreAttachment;
use App\Http\Requests\Attachments\UpdateAttachment;
use App\Http\Requests\Request;
use App\Models\Attachment;
use DB;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
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
        $data['attachments'] = Attachment::with('users')->orderBy('id', 'ASC')->paginate(20);

        $storedFiles = [];
        $allAttachments = Attachment::all();
        foreach ($allAttachments as $storedFile)
        {
            $storedFiles[] = $storedFile['name'];
        }

        $files = File::allFiles('storage');

        $uploadedImgs = [];
        foreach ($files as $file)
        {
            $uploadedImgs[] = $file->getBasename();
        }

        $imgs = [];
        $imgs = array_diff($uploadedImgs, $storedFiles);

        return view('admin.listattachments', ['data' => $data, 'images' => $imgs]);
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

        /** @var UploadedFile $image */
        foreach ($request->images as $image)
        {
            $imageName = $image->getClientOriginalName();

            if (!$image->storeAs('public', $imageName)) {
                Session::flash('warning', "Did not store " .imageName);
                return null;
            }

            $attachment = new Attachment($request->input('attachment'));
            $attachment['name'] = $imageName;
            $attachment['extension'] = $image->getClientOriginalExtension();
            $attachment['user_id'] = Auth::id();

            $attachment->save();
        }

/*
        // get the date, month, year, make folder if not exist for storing stuff.
*/
        Session::flash('success', Str::plural(count($request->images) . ' Attachment', count($request->images)) . ' uploaded.');

        /*
        if one file, go to edit, if multiple uploads, what then?
        */


        return redirect()->route('attachment_edit', [$attachment->id]);
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

       // echo storage_path('app/public'); exit();

        $attachment['imageData'] = getimagesize(storage_path('app/public') .'/'. $attachment['name']);
        $attachment['filesize'] = $this->human_filesize(filesize(storage_path('app/public') .'/'. $attachment['name']));


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
    public function destroy(DestroyAttachment $request)
    {
        $attachments = Attachment::find($request->id);
        foreach($attachments as $a)
        {
            Storage::disk('public')->delete($a['name']);
            Attachment::destroy($a->id);
        }
        Session::flash('success', Str::plural(count($request->id) .' Attachment', count($request->id)) . ' deleted.');

        return redirect()->route('attachments_list');
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

    protected function human_filesize($bytes, $decimals = 2) {
        $factor = floor((strlen($bytes) - 1) / 3);
        if ($factor > 0) $sz = 'KMGT';
        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor - 1] . 'B';
    }
}
