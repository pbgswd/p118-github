<?php

namespace App\Http\Controllers;

use App\Models\Feature;
use App\Services\AttachmentService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Spatie\Image\Exceptions\InvalidManipulation;
use Spatie\Image\Image;
use Spatie\LaravelImageOptimizer\Facades\ImageOptimizer;

class AdminFeatureController extends Controller
{
    /** @var AttachmentService */
    private $attachmentService;

    public function __construct(AttachmentService $attachmentService)
    {
        $this->attachmentService = $attachmentService;
    }

    /**
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $data = [];

        $features = Feature::withoutGlobalScopes()
            ->sortable()
            ->paginate(20);

        $data = [
            'features' => $features,
        ];

        return view('admin.features-list', ['data' => $data]);
    }

    /**
     * @return View
     */
    public function create(): View
    {
        $data = [];

        $feature = new Feature;

        $data = [
            'feature' => $feature,
            'action' => 'Create',
        ];

        return view('admin.feature', ['data' => $data]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $feature = new Feature($request->input('feature'));

        $feature->save();

        Session::flash('success', 'You have saved a new feature');

        return redirect()->route('admin_feature_edit', [$feature->slug]);
    }


    /**
     * @param Feature $feature
     * @return View
     */
    public function edit(Feature $feature): View
    {
        $data = [];

        $data = [
            'feature' => $feature,
            'action' => 'Edit',
        ];

        return view('admin.feature', ['data' => $data]);
    }

    /**
     * @param Request $request
     * @param Feature $feature
     * @return RedirectResponse
     * @throws InvalidManipulation
     */
    public function update(Request $request, Feature $feature): RedirectResponse
    {

        $feature = $request->input('feature');

        dd($feature);

        if (isset($request['delete_image'])) {
            if (file_exists(storage_path() . '/app/public/' . $feature['image'])) {
                Storage::disk('users')->delete($feature['image']);
                Session::flash('info', 'You have deleted ' . $feature['file_name']);
                $feature['image'] = null;
                $feature['file_name'] = null;
            }
        }


        if (!is_null($request->file('image'))) {

            $feature['file_name'] = $request['image']->getClientOriginalName();
//todo image upload issue
            $feature['image'] = $this->uploadImage($request);

        }

            $feature->save();

            Session::flash('success', 'You have edited the Feature');

            return redirect()->route('admin_feature_edit', [$feature->slug]);

    }
    /**
     * @param Feature $feature
     * @return RedirectResponse
     * @throws \Exception
     */
    public function destroy(Feature $feature): RedirectResponse
    {
        Feature::withoutGlobalScopes()
            ->find($feature->id)
            ->each(function (Feature $feature) {
              $feature->delete();
            });

        Session::flash('success', 'You have deleted the Feature');
        return redirect()->route('admin_features_list');
    }


    /**
     * @param FormRequest $request
     * @return string
     * @throws InvalidManipulation
     */
    protected function uploadImage(Request $request): string
    {
        if (null !== $request->file('image')) {

            $file = $request->file('image')->store('', 'public');

            ImageOptimizer::optimize(storage_path() . '/app/public/' . $file);

            Image::load(storage_path() . '/app/public/' . $file)
                ->width(75)
                ->height(75)
                ->save(storage_path() . '/app/public/' . 'tn_75x75_' . $file);

            return $file;
        }
        return false;
    }
}
