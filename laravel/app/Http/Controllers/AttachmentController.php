<?php

namespace App\Http\Controllers;

use App\Http\Requests\Attachments\DestroyAttachment;
use App\Http\Requests\Attachments\StoreAttachment;
use App\Http\Requests\Attachments\UpdateAttachment;
use App\Models\Attachment;
use App\Services\AttachmentService;
use DB;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Storage;
use Validator;

class AttachmentController extends Controller
{
    /** @var AttachmentService*/
    private $attachmentService;

    public function __construct(AttachmentService $attachmentService)
    {
        $this->attachmentService = $attachmentService;
    }


    public function download(string $folder, Attachment $attachment)
    {
//todo policy, security for download attachment method?
        return $this->attachmentService->downloadAttachment($attachment, $folder);
    }

    /**
     * @param Attachment $attachment
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Attachment $attachment)
    {
        $this->authorize('viewAny', Auth::user());

        $data = [];
        $data['attachments'] = Attachment::with('users')->orderBy('id', 'ASC')->paginate(30);

        $storedFiles = [];
        $allAttachments = Attachment::all();
        foreach ($allAttachments as $storedFile)
        {
            $storedFiles[] = $storedFile['name'];
        }

        $files = File::allFiles('storage');

        $data['filecount'] = count($files);

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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Auth::user());

        $attachment = new Attachment;

        return view('admin.attachment', ['data' => ['attachment' => $attachment, 'action' => 'Add']]);
    }

    /**
     * @param StoreAttachment $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreAttachment $request)
    {
        $this->authorize('create', Auth::user());

        /** @var UploadedFile $image */

        foreach ($request->file('images') as $image)
        {
            //todo analyse attachment file size, resize, create thumb when it is an image -- A SERVICE
            $file = '';
            $file = $image->store('', 'public');
            $imageName = $image->getClientOriginalName();
            $attachment = new Attachment();
            $attachment['file_name'] = $imageName;
            $attachment['file'] = $file;
            $attachment['user_id'] = Auth::id();
            $attachment->save();
        }

        Session::flash('success', Str::plural(count($request->images) . ' Attachment', count($request->images)) . ' uploaded.');

        if(count($request->file('images')) == 1 ) {
            return redirect()->route('attachment_edit', [$attachment->id]);
        }
        else
        {
            return redirect()->route('attachments_list');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Attachment $attachment
     * @return Response
     */
    public function show(Attachment $attachment)
    {
//todo delete show method if not needed
    }

    /**
     * @param Attachment $attachment
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Attachment $attachment)
    {
        $this->authorize('update', Auth::user());

        if(!file_exists(storage_path('app/' . $attachment->subfolder) . '/' . $attachment->file))
        {
            Session::flash('error',  $attachment->file_name . " was not found on the server");
            return redirect()->route('attachments_list');
            exit();
        }

        $path_info = pathinfo(storage_path('app/' . $attachment->subfolder) . '/' . $attachment['file']);
        $attachment['extension'] = $path_info['extension'];

        $attachment['imageData'] = getimagesize(storage_path('app/' . $attachment->subfolder) . '/' . $attachment['file']);
        $attachment['filesize'] = $this->human_filesize(filesize(storage_path('app/' . $attachment->subfolder) . '/' . $attachment['file']));

        return view('admin.attachment', ['data' => ['attachment' => $attachment, 'action' => 'Edit']]);
    }

    /**
     * @param UpdateAttachment $request
     * @param Attachment $attachment
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateAttachment $request, Attachment $attachment)
    {
        $this->authorize('update', Auth::user());
        //todo no actions programmatically really.
        return view('admin.attachment', ['data' => ['attachment' => $attachment, 'action' => 'Edit']]);
    }

    /**
     * @param DestroyAttachment $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(DestroyAttachment $request)
    {
        $this->authorize('delete', Auth::user());

        $attachments = Attachment::find($request->id);
        foreach ($attachments as $a)
        {
            Storage::disk('public')->delete($a['file']);
            Attachment::destroy($a->id);
        }
        Session::flash('success', Str::plural(count($request->id) . ' Attachment', count($request->id)) . ' deleted.');

        return redirect()->route('attachments_list');
    }


    protected function human_filesize($bytes, $decimals = 2)
    {
        $factor = floor((strlen($bytes) - 1) / 3);
        if ($factor > 0) $sz = 'KMGT';
        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor - 1] . 'B';
    }
}
