<?php

namespace App\Http\Controllers;

use App\Models\Feature;
use App\Models\Options;
use App\Services\AttachmentService;
use Illuminate\Http\Request;

class FeatureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): view
    {
        $data = [];

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
     * Display the specified resource.
     *
     * @param  \App\Models\Feature  $feature
     * @return \Illuminate\Http\Response
     */
    public function show(Feature $feature)
    {
        $data = [];

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
}
