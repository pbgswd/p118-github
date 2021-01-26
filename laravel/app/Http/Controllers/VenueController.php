<?php

namespace App\Http\Controllers;

use App\Models\Venue;
use Auth;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Response;
use Illuminate\View\View;

class VenueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function list()
    {
        $data = [];
        $data['venues'] = Venue::paginate(8);
        return view('venues', ['data' => ['data' => $data]]);
    }

    /**
     * @param Venue $venue
     * @return Factory|View
     */
    public function show(Venue $venue)
    {
        $data['venue'] = $venue;
        $data['agreements'] = Auth::check() ? $venue->member_agreements : $venue->agreements;

        return view('venue', ['data' => $data]);
    }
}
