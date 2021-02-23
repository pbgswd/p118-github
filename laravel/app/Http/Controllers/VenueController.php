<?php

namespace App\Http\Controllers;

use App\Models\Options;
use App\Models\Venue;
use App\Services\UserImageService;
use Auth;
use Illuminate\View\View;

class VenueController extends Controller
{
    public function __construct(UserImageService $userImageService)
    {
        $this->userImageService = $userImageService;
    }

    /**
     * @return View
     */
    public function list(): View
    {
        $data = [];
        $access = Auth::check() ? 'members' : 'public';

        $data['venues'] = Venue::where('live', 1)
            ->orderBy('name')
            //->whereIn('access_level', ['public', $access])
            ->paginate(9);

        $data['tn_prefix'] = Options::venue_org_thumb_values()['tn_str'];

        return view('venues', ['data' =>  $data]);
    }

    /**
     * @param Venue $venue
     * @return View
     */
    public function show(Venue $venue): View
    {
        $agreements = Auth::check() ? $venue->member_agreements : $venue->agreements;

        if($venue['image']) {
            if(file_exists(storage_path() . '/app/public/' . $venue['image'])) {

                if(!file_exists(storage_path() . '/app/public/' . Options::venue_org_thumb_values()['tn_str'] .
                    $venue['image'])) {
                    $this->userImageService->generate_thumb($venue['image'], 'public',
                        Options::venue_org_thumb_values());
                }
            }
            $venue->thumb = Options::venue_org_thumb_values()['tn_str'] . $venue['image'];
        }

        $data = [
            'venue' => $venue,
            'agreements' => $agreements,
            ];

        return view('venue', ['data' => $data]);
    }
}
