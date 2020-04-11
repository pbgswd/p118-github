<?php

namespace App\Http\Controllers;

use App\Models\Venue;
use Auth;
use Illuminate\Http\Response;


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
        $data['venues'] = Venue::paginate(20);

        return view('venues', ['data' => ['data' => $data]]);
    }


    /**
     * @param Venue $venue
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Venue $venue)
    {
        $this->authorize('view', Auth::user());

        $venue->load('agreements');

        return view('venue', ['data' => ['venue' => $venue]]);
    }
}
