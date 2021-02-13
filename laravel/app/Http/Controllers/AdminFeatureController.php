<?php

namespace App\Http\Controllers;

use App\Http\Requests\Feature\DestroyFeatureRequest;
use App\Http\Requests\Feature\StoreFeatureRequest;
use App\Http\Requests\Feature\UpdateFeatureRequest;
use App\Models\Feature;
use App\Models\Options;
use App\Services\AttachmentService;
use App\Services\UserImageService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Spatie\Image\Exceptions\InvalidManipulation;

class AdminFeatureController extends Controller
{
    /** @var AttachmentService */
    private $attachmentService;
    /**
     * @var UserImageService
     */
    private $userImageService;

    public function __construct(AttachmentService $attachmentService, UserImageService $userImageService)
    {
        $this->attachmentService = $attachmentService;
        $this->userImageService = $userImageService;
    }

    /**
     * @param Request $request
     * @return View
     * @throws AuthorizationException
     */
    public function index(Request $request): View
    {
        $this->authorize('viewAny', Feature::class);

        $features = Feature::withoutGlobalScopes()
            ->sortable()
            ->paginate(20);

        $data = [
            'features' => $features,
            'thumbs' => Options::feature_thumb_values(),
        ];

        return view('admin.features-list', ['data' => $data]);
    }

    /**
     * @return View
     * @throws AuthorizationException
     */
    public function create(): View
    {
        $this->authorize('create', Feature::class);

        $feature = new Feature;

        $data = [
            'feature' => $feature,
            'action' => 'Create',
        ];

        return view('admin.feature', ['data' => $data]);
    }

    /**
     * @param StoreFeatureRequest $request
     * @param UserImageService $service
     * @return RedirectResponse
     * @throws InvalidManipulation
     * @throws AuthorizationException
     */
    public function store(StoreFeatureRequest $request, UserImageService $service): RedirectResponse
    {
        $this->authorize('create', Feature::class);

        $feature = new Feature($request->input('feature'));

        if (null !== $request->file('image')) {

            $file = $request->file('image')->store('', 'public');

            $result = $this->userImageService->updateImage($request, 'public', true, Options::feature_thumb_values());

            $feature['image'] = $result['image'];
            $feature['file_name'] = $result['file_name'];
        }

        $feature->save();

        Session::flash('success', 'You have saved a new feature');

        return redirect()->route('admin_feature_edit', [$feature->slug]);
    }


    /**
     * @param Feature $feature
     * @return View
     * @throws AuthorizationException
     * @throws InvalidManipulation
     */
    public function edit(Feature $feature): View
    {
        $this->authorize('update', Feature::class);

        if($feature['image']) {
            if(file_exists(storage_path() . '/app/public/' . $feature['image'])) {
                $feature->filesize = AttachmentService::human_filesize(
                    \filesize(\storage_path('app/public' . '/' . $feature->image))) ? : null;

                if(!file_exists(storage_path() . '/app/public/' . Options::feature_thumb_values()['tn_str'] .
                    $feature['image'])) {
                    $this->userImageService->generate_thumb($feature['image'], 'public',
                        Options::feature_thumb_values());
                }
            }
            $feature->thumb = Options::feature_thumb_values()['tn_str'] . $feature['image'];
            $feature->thumb_size = AttachmentService::human_filesize(
                \filesize(\storage_path('app/public' . '/' . $feature->thumb))) ? : null;
        }

        $data = [
            'feature' => $feature,
            'action' => 'Edit',
        ];

        return view('admin.feature', ['data' => $data]);
    }

    /**
     * @param UpdateFeatureRequest $request
     * @param Feature $feature
     * @return RedirectResponse
     * @throws AuthorizationException
     * @throws InvalidManipulation
     */
    public function update(UpdateFeatureRequest $request, Feature $feature): RedirectResponse
    {
        $this->authorize('update', Feature::class);

        $feature->fill($request->input('feature'));

        if (isset($request['delete_image'])) {
            if (file_exists(storage_path() . '/app/public/' . $feature['image'])) {

                $this->userImageService->destroyImage($feature['image'], 'public', Options::feature_thumb_values());

                Session::flash('info', 'You have deleted ' . $feature['file_name']);
                $feature['image'] = null;
                $feature['file_name'] = null;
            }
        }

        if (null !== $request->file('image')) {

            $file = $request->file('image')->store('', 'public');

            $result = $this->userImageService->updateImage($request, 'public', true, Options::feature_thumb_values());

            $feature['file_name'] = $request['image']->getClientOriginalName();
            $feature['image'] = $result['image'];
            $feature['file_name'] = $result['file_name'];
        }

        $feature->save();

        Session::flash('success', 'You have edited the Feature');

        return redirect()->route('admin_feature_edit', [$feature->slug]);

    }

    /**
     * @param DestroyFeatureRequest $request
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function destroy(DestroyFeatureRequest $request): RedirectResponse
    {
        $this->authorize('delete', Feature::class);

        Feature::withoutGlobalScopes()
            ->find($request->id)
            ->each(function (Feature $feature) {
              $feature->delete();
            });

        Session::flash('success', 'You have deleted the Feature');
        return redirect()->route('admin_features_list');
    }
}
