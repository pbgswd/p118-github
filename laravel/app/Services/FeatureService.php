<?php

namespace App\Services;

use App\Models\Feature;
use App\Models\Options;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class FeatureService
{
    private UserImageService $userImageService;

    public function __construct(UserImageService $userImageService)
    {
        $this->userImageService = $userImageService;
    }

    public function createPolicyFeature($data): Feature
    {
        $additional_data = '<hr />
                            <b>Date Policy is in Effect: '.$data['date']->format('F j Y').'</b>
                            </b>';

        $feature = [
            'title' => 'Policy: '.$data->title,
            'slug' => 'policy-'.$data->id,
            'content' => $data->description.$additional_data,
            'url' => $data->source_url,
            'image' => null,
            'file_name' => null,
            'date' => Carbon::now(),
            'access_level' => 'members',
            'live' => 0,
            'front_page' => 0,
            'landing_page' => 0,
        ];

        return self::createFeature($feature);
    }

    public function createMeetingFeature($data): Feature
    {
        $additional_data = '<hr />
                            <b>Date of Meeting: '.$data['date']->format('F j Y').'</b>
                            </b>';

        $feature = [
            'title' => 'Meeting Minutes: '.$data->title,
            'slug' => 'meeting-minutes-'.$data->id,
            'content' => $data->description.$additional_data,
            'url' => $data->source_url,
            'image' => null,
            'file_name' => null,
            'date' => Carbon::now(),
            'access_level' => 'members',
            'live' => 0,
            'front_page' => 0,
            'landing_page' => 0,
        ];

        return self::createFeature($feature);
    }

    public function createEmploymentFeature($data): Feature
    {
        $additional_data = '<hr />
                            <b>Date Posted: '.$data['created_at']->format('F j Y').'</b>
                            <br />
                            <b>End date for application: '.$data['deadline']->format('F j Y').
                            '</b>';

        $feature = [
            'title' => 'Job Posting: '.$data->title,
            'slug' => 'job-posting-'.$data->id,
            'content' => $data->content.$additional_data,
            'url' => $data->source_url,
            'image' => null,
            'file_name' => null,
            'date' => Carbon::now(),
            'access_level' => 'members',
            'live' => 0,
            'front_page' => 0,
            'landing_page' => 0,
        ];

        return self::createFeature($feature);
    }

    public function createMemoriamFeature($data): Feature
    {
        $additional_data = '<hr /> <b>Date of passing: '.$data['date']->format('F j Y').'</b>';

        $folder = $data->getAttachmentFolder();

        if ($data['image']) {
            $tn_str = Options::memoriam_thumb_values()['tn_str'];

            //  $fthumbvals = ;

            if (file_exists(storage_path().'/app/'.$folder.'/'.$data['image'])) {
                $feature = new Feature;
                $featureFolder = $feature->getAttachmentFolder();
                Storage::putFileAs($featureFolder, storage_path().'/app/'.$folder.'/'.$data['image'], $data['image']);
                $this->userImageService->generate_thumb($data['image'], $featureFolder, Options::feature_thumb_values());
                // $data->thumb = $tn_str.$data['image'];
            }
        }

        $feature = [
            'title' => 'In Memoriam: '.$data->title,
            'slug' => 'in-memoriam-'.$data->slug,
            'content' => $data->content.$additional_data,
            'url' => $data->source_url,
            'image' => $data->image,
            'file_name' => $data->file_name,
            'date' => Carbon::now(),
            'access_level' => 'members',
            'live' => 0,
            'front_page' => 0,
            'landing_page' => 0,
        ];

        return self::createFeature($feature);
    }

    public function createCommitteePostFeature($data): Feature
    {
        $feature = [
            'title' => $data->committee->name.': '.$data->title,
            'slug' => $data->committee->slug.'-'.$data->slug,
            'content' => $data->content,
            'url' => $data->source_url,
            'image' => null,
            'file_name' => null,
            'date' => Carbon::now(),
            'access_level' => 'members',
            'live' => 0,
            'front_page' => 0,
            'landing_page' => 0,
        ];

        return self::createFeature($feature);
    }

    public function createPageFeature($data): Feature
    {
        $feature = [
            'title' => 'Feature: '.$data->title,
            'slug' => $data->slug,
            'content' => $data->content,
            'url' => $data->source_url,
            'image' => null,
            'file_name' => null,
            'date' => Carbon::now(),
            'access_level' => 'members',
            'live' => 0,
            'front_page' => 0,
            'landing_page' => 0,
        ];

        return self::createFeature($feature);
    }

    public function createPostFeature($data): Feature
    {

        $feature = [
            'title' => 'Feature: '.$data->title,
            'slug' => $data->slug,
            'content' => $data->content,
            'url' => $data->source_url,
            'image' => null,
            'file_name' => null,
            'date' => Carbon::now(),
            'access_level' => 'members',
            'live' => 0,
            'front_page' => 0,
            'landing_page' => 0,
        ];

        return self::createFeature($feature);
    }

    public function createFeature($data): Feature
    {
        $fea = new Feature($data);
        $fea->save();

        return $fea;
    }
}
