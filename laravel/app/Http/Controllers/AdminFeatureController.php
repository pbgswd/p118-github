<?php

namespace App\Http\Controllers;

use App\Models\Feature;
use App\Services\AttachmentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

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
     */
    public function update(Request $request, Feature $feature): RedirectResponse
    {

        $feature->fill($request->feature);
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
}
