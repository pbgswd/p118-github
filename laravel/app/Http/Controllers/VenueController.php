<?php

namespace App\Http\Controllers;

use App\Models\Options;
use App\Models\Venue;
use App\Services\UserImageService;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Spatie\Image\Exceptions\InvalidManipulation;

class VenueController extends Controller
{
    private UserImageService $userImageService;

    public function __construct(UserImageService $userImageService)
    {
        $this->userImageService = $userImageService;
    }

    public function list(): View
    {
        $data['venues'] = Venue::where('live', 1)
            ->orderBy('name')
            ->whereIn('access_level', ['public', Auth::check() ? 'members' : ''])
            ->paginate(9);

        $data['tn_prefix'] = Options::venue_org_thumb_values()['tn_str'];

        $data['title'] = "Venues";

        return view('venues', ['data' => $data]);
    }

    /**
     * @throws InvalidManipulation
     */
    public function show(Venue $venue): View
    {
        if ($venue['image']) {
            if (file_exists(storage_path().'/app/public/'.$venue['image'])) {
                if (! file_exists(storage_path().'/app/public/'.Options::venue_org_thumb_values()['tn_str'].
                    $venue['image'])) {
                    $this->userImageService->generate_thumb($venue['image'], 'public',
                        Options::venue_org_thumb_values());
                }
            }
            $venue->thumb = Options::venue_org_thumb_values()['tn_str'].$venue['image'];
        }

        $venue->load('attachments');

        $data = [
            'venue' => $venue,
            'agreements' => Auth::check() ? $venue->member_agreements()->paginate(5) :
                $venue->agreements()->paginate(5),
            'title' => "$venue->name",
        ];

        return view('venue', ['data' => $data]);
    }
}
