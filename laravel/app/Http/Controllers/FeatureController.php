<?php

namespace App\Http\Controllers;

use App\Models\Feature;
use App\Models\Options;
use Illuminate\View\View;

class FeatureController extends Controller
{
    public function index(): View
    {
        $features = Feature::withoutGlobalScopes()
            ->where('live', 1)
            ->orderBy('created_at', 'desc')
            ->sortable()
            ->paginate(10);

        $data = [
            'features' => $features,
            'thumbs' => Options::feature_thumb_values(),
            'title' => 'Feature News',
        ];

        return view('features', ['data' => $data]);
    }

    public function show(Feature $feature): View
    {
        if ($feature['image']) {
            if (file_exists(storage_path().'/app/public/'.$feature['image'])) {
                if (! file_exists(storage_path()
                    .'/app/public/'.Options::feature_thumb_values()['tn_str'].
                    $feature['image'])) {
                    $this->userImageService
                        ->generate_thumb($feature['image'], 'public',
                            Options::feature_thumb_values());
                }
            }
            $feature->thumb = Options::feature_thumb_values()['tn_str']
                .$feature['image'];
        }

        $data = [
            'feature' => $feature,
            'action' => 'Edit',
            'title' => $feature->title,
        ];

        return view('feature', ['data' => $data]);
    }
}
