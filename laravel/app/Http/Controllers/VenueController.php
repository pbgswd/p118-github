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
        // public

        $data = [];
        $data['venues'] = Venue::paginate(20);

        return view('venues', ['data' => array('data' => $data)]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Auth::user());
        $venue = new Venue;

        $access_levels = $this->getFormOptions(['access_levels']);

        return view('admin.venue', ['data' => ['venue' => $venue, 'access_levels' => $access_levels, 'action' => 'Create']]);
    }

    /**
     * @param StoreVenue $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreVenue $request)
    {
        $this->authorize('create', Auth::user());

        $venue = new Venue($request->input('venue'));

        $venue->save();
        Session::flash('success', "You have saved a new venue");

        return redirect()->route('venue_edit', [$venue->slug]);
    }

    /**
     * @param Venue $venue
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Venue $venue)
    {
        //todo public / member view
        $this->authorize('view', Auth::user());

        return view('venue', ['data' => ['venue' => $venue]]);
    }

    /**
     * @param Venue $venue
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Venue $venue)
    {
        $this->authorize('update', Auth::user());

        $access_levels = $this->getFormOptions(['access_levels']);

        return view('admin.venue', ['data' => ['venue' => $venue, 'access_levels' => $access_levels, 'action' => 'Edit']]);
    }

    /**
     * @param UpdateVenue $request
     * @param Venue $venue
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateVenue $request, Venue $venue)
    {
        $this->authorize('update', Auth::user());
        $venue->fill($request['venue']);
        $venue->save();
        Session::flash('success', "You have edited the venue");

        return redirect()->route('venue_edit', [$venue->slug]);
    }

    /**
     * @param DestroyVenue $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(DestroyVenue $request)
    {
        $this->authorize('delete', Auth::user());
        $venues = Venue::find($request->id);
        foreach ($venues as $v)
        {
            Venue::destroy($v->id);
        }
        Session::flash('success', Str::plural(count($request->id) . ' Venue', count($request->id)) . ' deleted.');

        return redirect()->route('venues_list');
    }

}
