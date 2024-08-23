<?php

namespace App\Http\Controllers;

use App\Constants\AccessLevelConstants;
use App\Http\Requests\Attachments\DestroyAttachmentRequest;
use App\Http\Requests\Attachments\StoreAttachmentRequest;
use App\Http\Requests\Attachments\UpdateAttachmentRequest;
use App\Models\Attachment;
use App\Services\AttachmentService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Support\Facades\File;

class AttachmentController extends Controller
{
    /** @var AttachmentService */
    private $attachmentService;

    public function __construct(AttachmentService $attachmentService)
    {
        $this->attachmentService = $attachmentService;
    }

    public function download(string $folder, Attachment $attachment)
    {
        return $this->attachmentService->downloadAttachment($attachment, $folder);
    }

    /**
     * @param Attachment $attachment
     * @return View
     * @throws AuthorizationException
     */
    public function index(Attachment $attachment): View
    {
        $this->authorize('viewAny', Auth::user());

        $data = [];
        $data['attachments'] = Attachment::with('user')->orderBy('id', 'DESC')->paginate(30);

        $data['filecount'] = Attachment::count();

        return view('admin.list_attachments', ['data' => $data]);
    }

    /**
     * @param Attachment $attachment
     * @return View
     * @throws AuthorizationException
     */
    public function index_icons(Attachment $attachment): View
    {
        $this->authorize('viewAny', Auth::user());

        $data = [];
        $data['attachments'] = Attachment::with('user')->orderBy('id', 'DESC')->paginate(30);

        $data['filecount'] = Attachment::count();

        $data['attachments']->each(function ($item) {
            $item->file_type = File::extension('storage/' . $item->subfolder . '/' . $item->file);
            $item->file_size = round(File::size('storage/' . $item->subfolder . '/' . $item->file)/1024, 2);
        });

        return view('admin.list_attachments_icons', ['data' => $data]);
    }



    /**
     * @throws AuthorizationException
     */
    public function create(): View
    {
        $this->authorize('create', Auth::user());

        $attachment = new Attachment;

        return view('admin.attachment', [
            'data' => [
                'attachment' => $attachment,
                'access_levels' => array_combine(AccessLevelConstants::getConstants(),
                    AccessLevelConstants::getConstants()),
                'action' => 'Add',
            ],
        ]);
    }

    /**
     * @throws AuthorizationException
     */
    public function store(StoreAttachmentRequest $request): RedirectResponse
    {
        $this->authorize('create', Auth::user());

        $attachment = '';

        foreach ($request->file('images') as $image) {
            $file = $image->store('', 'public');
            $imageName = $image->getClientOriginalName();
            $attachment = new Attachment();
            $attachment['file_name'] = $imageName;
            $attachment['file'] = $file;
            $attachment['access_level'] = $request->attachment['access_level'];
            $attachment['user_id'] = Auth::id();
            $attachment->save();
        }

        Session::flash('success', Str::plural(count($request->images).
                ' Attachment', count($request->images)).' uploaded.');

        if (count($request->file('images')) == 1) {
            return redirect()->route('admin_attachment_edit', $attachment->id);
        }

        return redirect()->route('attachments_list');
    }

    /**
     * @throws AuthorizationException
     */
    public function edit(Attachment $attachment): View
    {
        $this->authorize('update', Auth::user());

        if (! \file_exists(\storage_path('app/'.$attachment->subfolder).'/'.$attachment->file)) {
            Session::flash('error', $attachment->file_name.' was not found on the server');

            return \redirect()->route('attachments_list');
        } else {
            $attachment->setCalculatedProperties();
        }

        $data = [
            'attachment' => $attachment,
            'access_levels' => array_combine(AccessLevelConstants::getConstants(),
                AccessLevelConstants::getConstants()),
            'action' => 'Edit',
        ];

        return view('admin.attachment', ['data' => $data]);
    }

    /**
     * @throws AuthorizationException
     */
    public function update(UpdateAttachmentRequest $request, Attachment $attachment): RedirectResponse
    {
        $this->authorize('update', Auth::user());
        $attachment->fill($request->attachment);
        $attachment->save();

        Session::flash('success', 'You have updated '.$attachment->file_name);

        return redirect()->route('admin_attachment_edit', $attachment->id);
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy(DestroyAttachmentRequest $request): RedirectResponse
    {
        $this->authorize('delete', Auth::user());

        $attachments = Attachment::find($request->id);
        foreach ($attachments as $a) {
            Storage::disk($a->subfolder)->delete($a->file);
            Attachment::destroy($a->id);
        }

        Session::flash('success', Str::plural(count($request->id).
                ' Attachment', count($request->id)).' deleted.');

        return redirect()->route('attachments_list');
    }
}
