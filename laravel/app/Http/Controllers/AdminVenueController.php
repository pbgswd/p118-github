<?php

namespace App\Http\Controllers;

use App\Http\Requests\Venues\DestroyVenueRequest;
use App\Http\Requests\Venues\StoreVenueRequest;
use App\Http\Requests\Venues\UpdateVenueRequest;
use App\Models\Venue;
use Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;


class AdminVenueController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('viewAny', Auth::user());

        $data = [];
        $data['venues'] = Venue::withoutGlobalScopes()->sortable()->orderBy('name')->paginate(10);

        return view('admin.listvenues', ['data' => ['data' => $data]]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Auth::user());
        $venue = new Venue;

        return view('admin.venue', [
            'data' => [
                'venue' => $venue,
                'access_levels' => $this->getFormOptions(['access_levels']),
                'action' => 'Create',
                ]
        ]);
    }

    /**
     * @param StoreVenueRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreVenueRequest $request)
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
    public function edit(Venue $any_venue)
    {
        $this->authorize('update', Auth::user());

        $access_levels = $this->getFormOptions(['access_levels']);

        return view('admin.venue', ['data' => [
            'venue' => $any_venue,
            'access_levels' => $access_levels,
            'action' => 'Edit',
            ]]);
    }

    /**
     * @param UpdateVenueRequest $request
     * @param Venue $any_venue
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateVenueRequest $request, Venue $any_venue)
    {
        $this->authorize('update', Auth::user());
        $any_venue->fill($request['venue']);
        $any_venue->save();
        Session::flash('success', "You have edited the venue");

        return redirect()->route('venue_edit', [$any_venue->slug]);
    }

    /**
     * @param DestroyVenueRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(DestroyVenueRequest $request)
    {
        $this->authorize('delete', Auth::user());

        Venue::withoutGlobalScopes()
            ->find($request->id)
            ->each(function (Venue $venue) {
                $venue->delete();
            });

        Session::flash('success', Str::plural(count($request->id) . ' Venue', count($request->id)) . ' deleted.');

        return redirect()->route('venues_list');
    }

}
