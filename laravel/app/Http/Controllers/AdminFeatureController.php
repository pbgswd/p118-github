<?php

namespace App\Http\Controllers;

use App\Constants\AccessLevelConstants;
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
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Spatie\Image\Exceptions\InvalidManipulation;

class AdminFeatureController extends Controller
{
    /** @var AttachmentService */
    private $attachmentService;

    public function __construct(AttachmentService $attachmentService)
    {
        //todo not using attachment service
        $this->attachmentService = $attachmentService;
    }

    /**
     * @throws AuthorizationException
     */
    public function index(Request $request): View
    {
        $this->authorize('viewAny', Feature::class);

        $features = Feature::withoutGlobalScopes()
            ->orderBy('date', 'desc')
            ->sortable()
            ->paginate(20);

        $data = [
            'features' => $features,
            'thumbs' => Options::feature_thumb_values(),
        ];

        return view('admin.features-list', ['data' => $data]);
    }

    /**
     * @throws AuthorizationException
     */
    public function create(): View
    {
        $this->authorize('create', Feature::class);

        $feature = new Feature;

        $data = [
            'feature' => $feature,
            'action' => 'Create',
            'access_levels' => array_combine(AccessLevelConstants::getConstants(),
                AccessLevelConstants::getConstants()),
        ];

        return view('admin.feature', ['data' => $data]);
    }

    /**
     * @throws InvalidManipulation
     * @throws AuthorizationException
     */
    public function store(StoreFeatureRequest $request, UserImageService $service): RedirectResponse
    {
        $this->authorize('create', Feature::class);

        $feature = new Feature($request->input('feature'));

        if ($request->file('image') !== null) {
            $file = $request->file('image')->store('', 'public');

            $result = $service->updateImage($request, 'public', true, Options::feature_thumb_values());

            $feature['image'] = $result['image'];
            $feature['file_name'] = $result['file_name'];
        }

        $feature->save();

        Session::flash('success', 'You have saved a new feature');

        return redirect()->route('admin_feature_edit', [$feature->slug]);
    }

    /**
     * @throws AuthorizationException
     * @throws InvalidManipulation
     */
    public function edit(Feature $feature, UserImageService $service): View
    {
        $this->authorize('update', Feature::class);

        if ($feature['image']) {
            $tn_str = Options::feature_thumb_values()['tn_str'];
            if (file_exists(storage_path().'/app/public/'.$feature['image'])) {
                $feature->filesize = AttachmentService::human_filesize(
                    \filesize(\storage_path('app/public/'.$feature->image))) ?: null;

                if (! file_exists(storage_path().'/app/public/'.$tn_str.$feature['image'])) {
                    $service->generate_thumb($feature['image'], 'public',
                        Options::feature_thumb_values());
                }
            }

            $feature->thumb = $tn_str.$feature['image'];

            $feature->thumb_size = AttachmentService::human_filesize(
                \filesize(\storage_path('app/public/'.$feature->thumb))) ?: null;
        }

        $data = [
            'feature' => $feature,
            'action' => 'Edit',
            'access_levels' => array_combine(AccessLevelConstants::getConstants(),
                AccessLevelConstants::getConstants()),
        ];

        return view('admin.feature', ['data' => $data]);
    }

    /**
     * @throws AuthorizationException
     * @throws InvalidManipulation
     */
    public function update(UpdateFeatureRequest $request, Feature $any_feature, UserImageService $service): RedirectResponse
    {
        $this->authorize('update', Feature::class);

        $any_feature->fill($request->input('feature'));

        if (isset($request['delete_image'])) {
            if (file_exists(storage_path().'/app/public/'.$any_feature['image'])) {
                $service->destroyImage($any_feature['image'], 'public', Options::feature_thumb_values());

                Session::flash('info', 'You have deleted '.$any_feature['file_name']);
                $any_feature['image'] = null;
                $any_feature['file_name'] = null;
            }
        }
        if ($request->file('image') !== null) {
            $file = $request->file('image')->store('', 'public');

            $result = $service->updateImage($request, 'public', true, Options::feature_thumb_values());

            $any_feature['file_name'] = $request['image']->getClientOriginalName();
            $any_feature['image'] = $result['image'];
        }

        $any_feature->save();

        Session::flash('success', 'You have edited the Feature');

        return redirect()->route('admin_feature_edit', [$any_feature->slug]);
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy(DestroyFeatureRequest $request): RedirectResponse
    {
        $this->authorize('delete', Feature::class);

        Feature::withoutGlobalScopes()
            ->find($request->id)
            ->each(function (Feature $feature) {
                if ($feature['image']) {
                    Storage::disk('public')->delete($feature['image']);
                    Storage::disk('public')->delete(Options::feature_thumb_values()['tn_str'].$feature['image']);
                }

                $feature->delete();
            });

        Session::flash('success', 'You have deleted the Feature');

        return redirect()->route('admin_features_list');
    }
}
