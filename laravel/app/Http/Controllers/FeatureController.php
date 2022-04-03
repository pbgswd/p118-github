<?php

namespace App\Http\Controllers;

use App\Models\Feature;
use App\Models\Options;
use Illuminate\View\View;

class FeatureController extends Controller
{
    /**
     * @return view
     */
    public function index(): View
    {
        $features = Feature::withoutGlobalScopes()
            ->where('live', 1)
            ->sortable()
            ->paginate(10);

        $data = [
            'features' => $features,
            'thumbs' => Options::feature_thumb_values(),
        ];

        return view('features', ['data' => $data]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Feature  $feature
     * @return \Illuminate\Http\Response
     */
    public function show(Feature $feature): View
    {
        //todo fix service reference
        if ($feature['image']) {
            if (file_exists(storage_path().'/app/public/'.$feature['image'])) {
                if (! file_exists(storage_path().'/app/public/'.Options::feature_thumb_values()['tn_str'].
                    $feature['image'])) {
                    $this->userImageService->generate_thumb($feature['image'], 'public',
                        Options::feature_thumb_values());
                }
            }
            $feature->thumb = Options::feature_thumb_values()['tn_str'].$feature['image'];
        }

        $data = [
            'feature' => $feature,
            'action' => 'Edit',
        ];

        return view('feature', ['data' => $data]);
    }
}
