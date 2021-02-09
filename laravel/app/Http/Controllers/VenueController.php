<?php

namespace App\Http\Controllers;

use App\Models\Venue;
use Auth;
use Illuminate\View\View;

class VenueController extends Controller
{
    /**
     * @return View
     */
    public function list(): View
    {
        $data = [];
        $access = Auth::check() ? 'members' : 'public';

        $data['venues'] = Venue::where('live', 1)
            ->whereIn('access_level', ['public', $access])
            ->sortable()
            ->orderBy('sort_order')
            ->paginate(10);

        return view('venues', ['data' => ['data' => $data]]);
    }

    /**
     * @param Venue $venue
     * @return View
     */
    public function show(Venue $venue): View
    {
        $agreements = Auth::check() ? $venue->member_agreements : $venue->agreements;

        $data = [
            'venue' => $venue,
            'agreements' => $agreements,
            ];

        return view('venue', ['data' => $data]);
    }
}
