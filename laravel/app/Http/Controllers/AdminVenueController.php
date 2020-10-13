<?php

namespace App\Http\Controllers;

use App\Http\Requests\Venues\DestroyVenueRequest;
use App\Http\Requests\Venues\StoreVenueRequest;
use App\Http\Requests\Venues\UpdateVenueRequest;
use App\Models\Agreement;
use App\Models\Venue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\View\View;


class AdminVenueController extends Controller
{
    /**
     * @return Factory|View
     */
    public function index()
    {
        $this->authorize('viewAny', Auth::user());

        $data = [];
        $data['venues'] = Venue::withoutGlobalScopes()->sortable()->orderBy('name')->paginate(10);

        return view('admin.listvenues', ['data' => ['data' => $data]]);
    }

    /**
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('create', Auth::user());

        $venue = new Venue;

        $all_agreements = Agreement::withoutGlobalScopes()->orderBy('title')->get();

        return view('admin.venue', [
            'data' => [
                'venue' => $venue,
                'all_agreements' => $all_agreements,
                'action' => 'Create',
            ]
        ]);
    }

    /**
     * @param StoreVenueRequest $request
     * @return RedirectResponse

     */
    public function store(StoreVenueRequest $request)
    {
        $this->authorize('create', Auth::user());

        $venue = new Venue($request->venue);

        $venue->save();

        $venue->agreements()->sync($request->all_agreements);

        Session::flash('success', "You have saved a new venue");

        return redirect()->route('venue_edit', [$venue->slug]);
    }

    /**
     * @param Venue $any_venue
     * @return Factory|View

     */
    public function edit(Venue $any_venue)
    {
        $this->authorize('update', Auth::user());

        $any_venue->load('member_agreements');

        $all_agreements = Agreement::whereNotIn(
            'id',
            $any_venue->agreements->map(function (Agreement $agreement) {
                return $agreement->id;
            }))
            ->orderBy('title')->get();

        $any_venue->setRelation('all_agreements', $all_agreements);

        return view('admin.venue', [
            'data' => [
                'venue' => $any_venue,
                'all_agreements' => $all_agreements,
                'action' => 'Edit',
            ]
        ]);
    }

    /**
     * @param UpdateVenueRequest $request
     * @param Venue $any_venue
     * @return RedirectResponse

     */
    public function update(UpdateVenueRequest $request, Venue $any_venue)
    {
        $this->authorize('update', Auth::user());

        $any_venue->fill($request['venue']);

        $any_venue->save();

        if(null !== $request->id) {
            $any_venue->member_agreements()->detach($request->id);
        }

        $any_venue->agreements()->attach($request->all_agreements);

        Session::flash('success', "You have edited the venue");

        return redirect()->route('venue_edit', [$any_venue->slug]);
    }

    /**
     * @param DestroyVenueRequest $request
     * @return RedirectResponse
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
