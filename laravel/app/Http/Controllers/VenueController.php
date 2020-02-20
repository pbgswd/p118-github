<?php

namespace App\Http\Controllers;

use App\Http\Requests\Venues\DestroyVenue;
use App\Http\Requests\Venues\StoreVenue;
use App\Http\Requests\Venues\UpdateVenue;
use App\Models\Venue;
use App\Models\Admin;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;


class VenueController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('viewAny', Auth::user());

        $data = [];
        $data['venues'] = Venue::sortable()->orderBy('name')->paginate(10);

        return view('admin.listvenues', ['data' => array('data' => $data)]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function list()
    {
        $data = [];
        $data['venues'] = Venue::paginate(20);

        return view('venues', ['data' => array('data' => $data)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $venue = new Venue;

        $access_levels = $this->getFormOptions(['access_levels']);

        return view('admin.venue', ['data' => ['venue' => $venue, 'access_levels' => $access_levels, 'action' => 'Create']]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(StoreVenue $request)
    {
        $venue = new Venue($request->input('venue'));

        $venue->save();
        Session::flash('success', "You have saved a new venue");

        return redirect()->route('venue_edit', [$venue->slug]);
    }

    /**
     * Display the specified resource.
     *
     * @param Venue $venue
     * @return Response
     */
    public function show(Venue $venue)
    {
        return view('venue', ['data' => ['venue' => $venue]]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Venue $venue
     * @return Response
     */
    public function edit(Venue $venue)
    {

        $access_levels = $this->getFormOptions(['access_levels']);

        return view('admin.venue', ['data' => ['venue' => $venue, 'access_levels' => $access_levels, 'action' => 'Edit']]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Venue $venue
     * @return Response
     */
    public function update(UpdateVenue $request, Venue $venue)
    {
        $venue->fill($request['venue']);
        $venue->save();
        Session::flash('success', "You have edited the venue");

        return redirect()->route('venue_edit', [$venue->slug]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Venue $venue
     * @return Response
     */
    public function destroy(DestroyVenue $request)
    {
        $venues = Venue::find($request->id);
        foreach ($venues as $v) {
            Venue::destroy($v->id);
        }
        Session::flash('success', Str::plural(count($request->id) . ' Venue', count($request->id)) . ' deleted.');

        return redirect()->route('venues_list');
    }

}
