<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Memoriam\DestroyMemoriamRequest;
use App\Http\Requests\Memoriam\StoreMemoriamRequest;
use App\Http\Requests\Memoriam\UpdateMemoriamRequest;
use App\Models\Memoriam;
use App\Models\Message;
use App\Models\Options;
use App\Services\AttachmentService;
use App\Services\FeatureService;
use App\Services\MessageService;
use App\Services\UserImageService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Spatie\Image\Exceptions\InvalidManipulation;

class AdminMemoriamController extends Controller
{
    /**
     * @var UserImageService
     */
    private UserImageService $userImageService;
    private MessageService $messageService;
    private FeatureService $featureService;

    public function __construct(UserImageService $userImageService, MessageService $messageService, FeatureService $featureService)
    {
        $this->userImageService = $userImageService;
        $this->messageService = $messageService;
        $this->featureService = $featureService;
    }

    /**
     * @throws AuthorizationException
     */
    public function index(): View
    {
        $this->authorize('viewAny', Memoriam::class);

        $memoriam = Memoriam::withoutGlobalScopes()
            ->sortable()
            ->orderBy('date', 'desc')
            ->paginate(10);

        $mem = new Memoriam;

        $data = [
            'memoriam' => $memoriam,
            'count' => Memoriam::all()->count(),
            'folder' => $mem->getAttachmentFolder(),
            'tn_str' => Options::memoriam_thumb_values()['tn_str'],
        ];

        return view('admin.memoriams', ['data' => $data]);
    }

    /**
     * @throws AuthorizationException
     */
    public function create(): View
    {
        $this->authorize('create', Memoriam::class);

        $memoriam = new Memoriam;

        $data = [
            'memoriam' => $memoriam,
            'action' => 'Create',
        ];

        return view('admin.memoriam', ['data' => $data]);
    }

    /**
     * @throws AuthorizationException
     * @throws InvalidManipulation
     */
    public function store(StoreMemoriamRequest $request): RedirectResponse
    {
        $this->authorize('create', Memoriam::class);

        $memoriam = new Memoriam($request->input('memoriam'));

        if ($request->file('image') !== null) {
            $folder = $memoriam->getAttachmentFolder();
            $file = $request->file('image')->store('', $folder);
            $result = $this->userImageService->updateImage($request, $folder, true, Options::memoriam_thumb_values());
            $memoriam['image'] = $result['image'];
            $memoriam['file_name'] = $request->file('image')->getClientOriginalName();
        }

        $memoriam->save();

        Session::flash('success', 'You have saved a new memoriam');

        return redirect()->route('admin_memoriam_edit', [$memoriam->slug]);
    }

    /**
     * @throws AuthorizationException
     * @throws InvalidManipulation
     */
    public function edit(Memoriam $memoriam): View
    {
        $this->authorize('update', Memoriam::class);

        $folder = $memoriam->getAttachmentFolder();

        if ($memoriam['image']) {
            $tn_str = Options::memoriam_thumb_values()['tn_str'];
            if (file_exists(storage_path().'/app/'.$folder.'/'.$memoriam['image'])) {
                $memoriam->filesize = AttachmentService::human_filesize(
                    \filesize(\storage_path('app/'.$folder.'/'.$memoriam->image))) ?: null;

                if (! file_exists(storage_path().'/app/'.$folder.'/'.$tn_str.$memoriam['image'])) {
                    $this->userImageService->generate_thumb($memoriam['image'], $folder, $tn_str);
                }
            }
            $memoriam->thumb = $tn_str.$memoriam['image'];
            $memoriam->thumb_size = AttachmentService::human_filesize(
                \filesize(\storage_path('app/'.$folder.'/'.$memoriam->thumb))) ?: null;
        }
//todo verify enough data for memoriam message
        $data = [
            'memoriam' => $memoriam,
            'existing_message' => Message::where('source_url',  env('APP_URL') . '/memoriam/' . $memoriam->slug)->exists(),
            'action' => 'Edit',
            'folder' => $folder,
            'model_name' => 'In Memoriam',
        ];

        return view('admin.memoriam', ['data' => $data]);
    }

    /**
     * @throws AuthorizationException
     */
    public function update(UpdateMemoriamRequest $request, Memoriam $any_memoriam): RedirectResponse
    {
        $this->authorize('update', Memoriam::class);

        $any_memoriam->fill($request->memoriam);

        $tn_str = Options::memoriam_thumb_values();

        $folder = $any_memoriam->getAttachmentFolder();

        if (isset($request['delete_image'])) {
            if (file_exists(storage_path().'/app/'.$folder.'/'.$any_memoriam['image'])) {
                $this->userImageService->destroyImage($any_memoriam['image'], $folder, $tn_str);

                Session::flash('info', 'You have deleted '.$any_memoriam['file_name']);
                $any_memoriam['image'] = null;
                $any_memoriam['file_name'] = null;
            }
        }

        if ($request->file('image') !== null) {
            $file = $request->file('image')->store('', $folder);
            $result = $this->userImageService->updateImage($request, $folder, true, $tn_str);
            $any_memoriam['image'] = $result['image'];
            $any_memoriam['file_name'] = $request->file('image')->getClientOriginalName();
        }

        $any_memoriam->save();

        return redirect()->route('admin_memoriam_edit', $any_memoriam->slug);
    }

    /**
     * @throws \Exception
     */
    public function destroy(DestroyMemoriamRequest $request): RedirectResponse
    {
        $this->authorize('delete', Memoriam::class);
        //todo deal with attachments for memoriams safely
        Memoriam::withoutGlobalScopes()
            ->find($request->id)
            ->each(function (Memoriam $memoriam) {
                //$this->attachmentService->destroyAttachments($memoriam);
                $memoriam->delete();
            });

        return redirect()->route('admin_memoriam_list');
    }


    /**
     * @throws AuthorizationException
     */
    public function message(Memoriam $memoriam): RedirectResponse
    {
        $this->authorize('update', Memoriam::class);
        $source_url = env('APP_URL') . '/memoriam/' . $memoriam->slug;
        if(Message::where('source_url',  $source_url)->exists()) {
            Session::flash('warning', 'A message from this content has already been created');
            return redirect()->route('admin_memoriam_edit', [$memoriam->slug]);
        }
        $memoriam->load('user');
        $memoriam->source_url = $source_url;
        $msg = $this->messageService->createMemoriamMessage($memoriam);
        Session::flash('success', 'new message from posts saved');

        return redirect()->route('admin_message_edit', [$msg->id, $msg->slug]);
    }

    public function feature(Memoriam $memoriam): RedirectResponse
    {
        $this->authorize('update', Memoriam::class);
        $memoriam->source_url = env('APP_URL') . '/memoriam/' . $memoriam->slug;
        $msg = $this->featureService->createMemoriamFeature($memoriam);
        Session::flash('success', 'new feature from In Memoriam saved');
        return redirect()->route('admin_feature_edit', [$msg->slug]);
    }
}
