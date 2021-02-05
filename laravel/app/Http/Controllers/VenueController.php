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
        $data['venues'] = Venue::paginate(8);
        return view('venues', ['data' => ['data' => $data]]);
    }

    /**
     * @param Venue $venue
     * @return View
     */
    public function show(Venue $venue): View
    {
        $data['venue'] = $venue;
        $data['agreements'] = Auth::check() ? $venue->member_agreements : $venue->agreements;

        return view('venue', ['data' => $data]);
    }
}
