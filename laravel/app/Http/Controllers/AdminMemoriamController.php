<?php

namespace App\Http\Controllers;

use App\Http\Requests\Memoriam\DestroyMemoriamRequest;
use App\Http\Requests\Memoriam\StoreMemoriamRequest;
use App\Http\Requests\Memoriam\UpdateMemoriamRequest;
use App\Models\Memoriam;
use App\Models\Options;
use App\Services\AttachmentService;
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
    private $userImageService;

    public function __construct(UserImageService $userImageService){
        $this->userImageService = $userImageService;
    }

    /**
     * @return View
     * @throws AuthorizationException
     */
    public function index(): View
    {
        $this->authorize('viewAny', Memoriam::class);

        $memoriam = Memoriam::withoutGlobalScopes()
            ->sortable()
            ->orderBy('date')
            ->paginate(10);

        $mem = new Memoriam;

        $data = [
            'memoriam' => $memoriam,
            'folder' => $mem->getAttachmentFolder(),
            'tn_str' => Options::memoriam_thumb_values()['tn_str'],
        ];

        return view('admin.memoriams', ['data' => $data]);
    }

    /**
     * @return View
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
     * @param StoreMemoriamRequest $request
     * @return RedirectResponse
     * @throws AuthorizationException
     * @throws InvalidManipulation
     */
    public function store(StoreMemoriamRequest $request): RedirectResponse
    {
        $this->authorize('create', Memoriam::class);

        $memoriam = new Memoriam($request->input('memoriam'));

        if (null !== $request->file('image')) {
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
     * @param Memoriam $memoriam
     * @return View
     * @throws AuthorizationException
     * @throws InvalidManipulation
     */
    public function edit(Memoriam $memoriam): View
    {
        $this->authorize('update', Memoriam::class);

        $folder = $memoriam->getAttachmentFolder();

        if($memoriam['image']) {
            $tn_str = Options::memoriam_thumb_values()['tn_str'];
            if(file_exists(storage_path() . '/app/'. $folder .'/'. $memoriam['image'])) {
                $memoriam->filesize = AttachmentService::human_filesize(
                    \filesize(\storage_path('app/'. $folder .'/'. $memoriam->image))) ? : null;

                if(!file_exists(storage_path() . '/app/'. $folder .'/'. $tn_str . $memoriam['image'])) {
                    $this->userImageService->generate_thumb($memoriam['image'], $folder, $tn_str);
                }
            }
            $memoriam->thumb = $tn_str . $memoriam['image'];
            $memoriam->thumb_size = AttachmentService::human_filesize(
                \filesize(\storage_path('app/'. $folder .'/'. $memoriam->thumb))) ? : null;
        }

        $data = [
            'memoriam' => $memoriam,
            'action' => 'Edit',
            'folder' => $folder,
        ];

         return view('admin.memoriam', ['data' => $data]);
    }

    /**
     * @param UpdateMemoriamRequest $request
     * @param Memoriam $any_memoriam
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function update(UpdateMemoriamRequest $request, Memoriam $any_memoriam): RedirectResponse
    {
        $this->authorize('update', Memoriam::class);

        $any_memoriam->fill($request->memoriam);

        $tn_str = Options::memoriam_thumb_values();

        $folder = $any_memoriam->getAttachmentFolder();

        if (isset($request['delete_image'])) {
            if (file_exists(storage_path() . '/app/'. $folder . '/'. $any_memoriam['image'])) {

                $this->userImageService->destroyImage($any_memoriam['image'], $folder, $tn_str);

                Session::flash('info', 'You have deleted ' . $any_memoriam['file_name']);
                $any_memoriam['image'] = null;
                $any_memoriam['file_name'] = null;
            }
        }

        if (null !== $request->file('image')) {

            $file = $request->file('image')->store('', $folder);
            $result = $this->userImageService->updateImage($request, $folder, true, $tn_str);
            $any_memoriam['image'] = $result['image'];
            $any_memoriam['file_name'] = $request->file('image')->getClientOriginalName();
        }


        $any_memoriam->save();

        return redirect()->route('admin_memoriam_edit', $any_memoriam->slug);
    }

    /**
     * @param DestroyMemoriamRequest $request
     * @return RedirectResponse
     * @throws \Exception
     */
    public function destroy(DestroyMemoriamRequest $request): RedirectResponse
    {
        $this->authorize('delete', Memoriam::class);

        Memoriam::withoutGlobalScopes()
            ->find($request->id)
            ->each(function (Memoriam $memoriam) {
                //$this->attachmentService->destroyAttachments($memoriam);
                $memoriam->delete();
            });
        return redirect()->route('admin_memoriam_list');
    }
}
