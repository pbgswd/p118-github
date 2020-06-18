<?php

namespace App\Http\Controllers;

use App\Models\Venue;
use Auth;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;


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

        $data['venue'] = $venue;
        $data['agreements'] = Auth::check() ? $venue->member_agreements : $venue->agreements;

        return view('venue', ['data' => $data]);
    }
}
