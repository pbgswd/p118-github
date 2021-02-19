<?php

namespace App\Http\Controllers;

use App\Http\Requests\Venues\DestroyVenueRequest;
use App\Http\Requests\Venues\StoreVenueRequest;
use App\Http\Requests\Venues\UpdateVenueRequest;
use App\Models\Agreement;
use App\Models\Venue;
use App\Services\AttachmentService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminVenueController extends Controller
{
    private $attachmentService;

    public function __construct(AttachmentService $attachmentService)
    {
        $this->attachmentService = $attachmentService;
    }

    /**
     * @return View
     * @throws AuthorizationException
     */
    public function index(): View
    {
        $this->authorize('viewAny', Venue::class);

        $data['venues'] = Venue::withoutGlobalScopes()
            ->sortable()
            ->orderBy('name')
            ->paginate(10);

        return view('admin.listvenues', ['data' => $data]);
    }

    /**
     * @return View
     * @throws AuthorizationException
     */
    public function create(): View
    {
        $this->authorize('create', Venue::class);

        $venue = new Venue;

        $all_agreements = Agreement::withoutGlobalScopes()->orderBy('title')->get();

        return view('admin.venue', [
            'data' => [
                'venue' => $venue,
                'all_agreements' => $all_agreements,
                'action' => 'Create',
            ],
        ]);
    }

    /**
     * @param StoreVenueRequest $request
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function store(StoreVenueRequest $request): RedirectResponse
    {
        $this->authorize('create', Venue::class);

        $venue = new Venue($request->venue);

        $venue->save();

        $venue->agreements()->sync($request->all_agreements);

        Session::flash('success', 'You have saved a new venue');

        return redirect()->route('venue_edit', [$venue->slug]);
    }

    /**
     * @param Venue $any_venue
     * @return View
     * @throws AuthorizationException
     */
    public function edit(Venue $any_venue): View
    {
        $this->authorize('update', Venue::class);

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
            ],
        ]);
    }

    /**
     * @param UpdateVenueRequest $request
     * @param Venue $any_venue
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function update(UpdateVenueRequest $request, Venue $any_venue): RedirectResponse
    {
        $this->authorize('update', Venue::class);

        $any_venue->fill($request['venue']);

        $any_venue->save();

        if (null !== $request->id) {
            $any_venue->member_agreements()->detach($request->id);
        }

        $any_venue->agreements()->attach($request->all_agreements);

        Session::flash('success', 'You have edited the venue');

        return redirect()->route('venue_edit', [$any_venue->slug]);
    }

    /**
     * @param DestroyVenueRequest $request
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function destroy(DestroyVenueRequest $request): RedirectResponse
    {
        $this->authorize('delete', Venue::class);

        Venue::withoutGlobalScopes()
            ->find($request->id)
            ->each(function (Venue $venue) {
                $venue->delete();
            });

        Session::flash('success', Str::plural(count($request->id).
                ' Venue', count($request->id)).' deleted.');

        return redirect()->route('venues_list');
    }
}
