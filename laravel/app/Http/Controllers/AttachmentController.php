<?php

namespace App\Http\Controllers;

use App\Http\Requests\Attachments\DestroyAttachment;
use App\Http\Requests\Attachments\StoreAttachment;
use App\Http\Requests\Attachments\UpdateAttachment;
use App\Models\Attachment;
use App\Services\AttachmentService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

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
     *
     * @return Factory|View
     */
    public function index(Attachment $attachment)
    {
        $this->authorize('viewAny', Auth::user());

        $data = [];
        $data['attachments'] = Attachment::with('user')->orderBy('id', 'ASC')->paginate(30);

        $storedFiles = [];
// todo: todoRTL: this method pulls _all_ attachments and _all_ files. is that necessary?
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

        $imgs = array_diff($uploadedImgs, $storedFiles);

        return view('admin.list_attachments', ['data' => $data, 'images' => $imgs]);
    }

    /**
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('create', Auth::user());

        $attachment = new Attachment;

        return view('admin.attachment', ['data' => ['attachment' => $attachment, 'action' => 'Add']]);
    }

    /**
     * @param StoreAttachment $request
     *
     * @return RedirectResponse
     */
    public function store(StoreAttachment $request): RedirectResponse
    {
        $this->authorize('create', Auth::user());

        /** @var UploadedFile $image */

        foreach ($request->file('images') as $image)
        {
            //todo analyse attachment file size, resize, create thumb when it is an image -- A SERVICE
            $file = $image->store('', 'public');
            $imageName = $image->getClientOriginalName();
            $attachment = new Attachment();
            $attachment['file_name'] = $imageName;
            $attachment['file'] = $file;
            $attachment['user_id'] = Auth::id();
            $attachment->save();
        }

        Session::flash('success', Str::plural(count($request->images) . ' Attachment', count($request->images)) . ' uploaded.');

        if (count($request->file('images')) == 1 ) {
            return redirect()->route('attachment_edit', [$attachment->id]);
        }

        return redirect()->route('attachments_list');
    }

    /**
     * @param Attachment $attachment
     *
     * @return Factory|RedirectResponse|View
     */
    public function edit(Attachment $attachment)
    {
        $this->authorize('update', Auth::user());

        if (!\file_exists(\storage_path('app/' . $attachment->subfolder) . '/' . $attachment->file))
        {
            Session::flash('error',  $attachment->file_name . " was not found on the server");
            return \redirect()->route('attachments_list');
        }

        $attachment->setCalculatedProperties();

        return view('admin.attachment', ['data' => ['attachment' => $attachment, 'action' => 'Edit']]);
    }

    /**
     * @param UpdateAttachment $request
     * @param Attachment $attachment
     *
     * @return Factory|View
     */
    public function update(UpdateAttachment $request, Attachment $attachment)
    {
        $this->authorize('update', Auth::user());
        //todo no actions programmatically really.
        return view('admin.attachment', ['data' => ['attachment' => $attachment, 'action' => 'Edit']]);
    }

    /**
     * @param DestroyAttachment $request
     *
     * @return RedirectResponse
     */
    public function destroy(DestroyAttachment $request): RedirectResponse
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
}
