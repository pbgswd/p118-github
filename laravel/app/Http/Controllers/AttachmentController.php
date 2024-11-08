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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

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
     * @throws AuthorizationException
     */
    public function index_icons(Attachment $attachment): View
    {
        $this->authorize('viewAny', Auth::user());

        $data = [];
        $data['content'] = fake()->paragraph();
        return view('admin.attachments.list_attachments_icons', ['data' => $data]);
    }

    public function ajax_upload(Request $request)
    {
        Log::info('peter '.__METHOD__.' line '.__LINE__.' '.serialize($request->all()));
        if ($request->hasFile('image')) {
            $file = $request->file('image');

            //todo options for storing image. Consider image upload service that already is there

            $path = $file->store('images', 'public'); // Store in the 'images' directory in public storage

            // Return the image path
            return response()->json(['url' => Storage::url($path)]);
        }

        return response()->json(['error' => 'No file uploaded'], 400);
    }

    public function endless(): View
    {
        return view('admin.attachments.list_attachments_endless');
    }

    public function endless_data(Request $request)
    {
        // https://alpine-ajax.js.org/examples/infinite-scroll/
        $data = [];
        $pagination = 30;
        $data['attachments'] = Attachment::with('user')->orderBy('id', 'DESC')
            ->paginate($pagination);
        $data['filecount'] = Attachment::count();
        $data['pages'] = intval(round(ceil($data['filecount']/$pagination),0));

        return response()->json(['data' => $data, 'records' => $data]);
    }

    /**
     * @throws AuthorizationException
     */
    public function index(Attachment $attachment): View
    {
        $this->authorize('viewAny', Auth::user());

        $data = [];
        $data['attachments'] = Attachment::with('user')->orderBy('id', 'DESC')->paginate(30);

        $data['filecount'] = Attachment::count();

        return view('admin.attachments.list_attachments', ['data' => $data]);
    }

    /**
     * @throws AuthorizationException
     */
    public function create(): View
    {
        $this->authorize('create', Auth::user());

        $attachment = new Attachment;

        return view('admin.attachments.attachment', [
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
            $attachment = new Attachment;
            $attachment['file_name'] = $imageName;
            $attachment['file'] = $file;

            $file_extension = File::extension('storage/public/' . $file);
            $file_type = in_array(strtolower($file_extension),
                ['jpg','jpeg','png','gif','webp','svg']) ? 'image': '';
            if(strtolower($file_extension)  == 'bin'){
                $file_type = 'binary';
            }
            if(strtolower($file_extension) == 'pdf'){
                $file_type = 'pdf';
            }
            if(strtolower($file_extension) == 'zip'){
                $file_type = 'zip';
            }
            if($file_type == ''){
                $file_type = 'file';
            }
            $attachment['file_type'] = $file_type;

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
    public function edit(Attachment $attachment)
    {
        $this->authorize('update', Auth::user());

        if (! \file_exists(\storage_path('app/'.$attachment->subfolder).'/'.$attachment->file)) {
            Session::flash('error', $attachment->file_name.' was not found on the server');
//todo remove this reidrect #############################################
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

        return view('admin.attachments.attachment', ['data' => $data]);
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
