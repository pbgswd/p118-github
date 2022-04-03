<?php

namespace App\Http\Controllers;

use App\Http\Requests\Venues\DestroyVenueRequest;
use App\Http\Requests\Venues\StoreVenueRequest;
use App\Http\Requests\Venues\UpdateVenueRequest;
use App\Models\Agreement;
use App\Models\Options;
use App\Models\Venue;
use App\Services\AttachmentService;
use App\Services\UserImageService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminVenueController extends Controller
{
    private $attachmentService;

    public function __construct(AttachmentService $attachmentService)
    {
        $this->attachmentService = $attachmentService;
        //$this->userImageService = $userImageService;
    }

    /**
     * @return View
     * @throws AuthorizationException
     */
    public function index(): View
    {
        $this->authorize('viewAny', Venue::class);

        $data['venues'] = Venue::withoutGlobalScopes()
            ->with('all_agreements', 'attachments')
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

        $data = [
            'venue' => new Venue,
            'all_agreements' => Agreement::withoutGlobalScopes()->orderBy('title')->get(),
            'access_levels' => Options::access_levels(),
            'action' => 'Create',
        ];

        return view('admin.venue', ['data' => $data]);
    }

    /**
     * @param StoreVenueRequest $request
     * @param UserImageService $service
     * @return RedirectResponse
     * @throws AuthorizationException
     * @throws \Spatie\Image\Exceptions\InvalidManipulation
     */
    public function store(StoreVenueRequest $request, UserImageService $service): RedirectResponse
    {
        $this->authorize('create', Venue::class);

        $venue = new Venue($request->venue);

        if (null !== $request->file('image')) {
            $file = $request->file('image')->store('', 'public');

            $result = $service->updateImage($request, 'public', true, Options::venue_org_thumb_values());

            $venue['image'] = $result['image'];
            $venue['file_name'] = $request->file('image')->getClientOriginalName();
        }

        if (null !== ($request->file('attachments'))) {
            $result = $this->attachmentService->createAttachment($request, $venue);
            if ($result) {
                Session::flash('success', 'You uploaded '.count($request->file('attachments')).
                    Str::plural(' file', count($request->file('attachments'))));
            } else {
                Session::flash('error', 'You have an upload problem');
            }
        }

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

        $any_venue->load('member_agreements', 'attachments');

        $all_agreements = Agreement::whereNotIn(
            'id',
            $any_venue->agreements->map(function (Agreement $agreement) {
                return $agreement->id;
            }))
            ->orderBy('title')->get();

        $any_venue->setRelation('all_agreements', $all_agreements);

        if ($any_venue['image']) {
            if (file_exists(storage_path().'/app/public/'.$any_venue['image'])) {
                $any_venue->filesize = AttachmentService::human_filesize(
                    \filesize(\storage_path('app/public'.'/'.$any_venue->image))) ?: null;

                if (! file_exists(storage_path().'/app/public/'.Options::venue_org_thumb_values()['tn_str'].
                    $any_venue['image'])) {
                    $this->userImageService->generate_thumb($any_venue['image'], 'public',
                        Options::venue_org_thumb_values());
                }
            }
            $any_venue->thumb = Options::venue_org_thumb_values()['tn_str'].$any_venue['image'];
            $any_venue->thumb_size = AttachmentService::human_filesize(
                \filesize(\storage_path('app/public'.'/'.$any_venue->thumb))) ?: null;
        }

        $data = [
            'venue' => $any_venue,
            'all_agreements' => $all_agreements,
            'access_levels' => Options::access_levels(),
            'action' => 'Edit',
        ];

        return view('admin.venue', ['data' => $data]);
    }

    /**
     * @param UpdateVenueRequest $request
     * @param Venue $any_venue
     * @param UserImageService $service
     * @return RedirectResponse
     * @throws AuthorizationException
     * @throws \Spatie\Image\Exceptions\InvalidManipulation
     */
    public function update(UpdateVenueRequest $request, UserImageService $service, Venue $any_venue): RedirectResponse
    {
        $this->authorize('update', Venue::class);

        $any_venue->fill($request['venue']);

        if (isset($request['delete_image'])) {
            if (file_exists(storage_path().'/app/public/'.$any_venue['image'])) {
                $service->destroyImage($any_venue['image'], 'public', Options::venue_org_thumb_values());

                Session::flash('info', 'You have deleted '.$any_venue['file_name']);
                $any_venue['image'] = null;
                $any_venue['file_name'] = null;
            }
        }

        if (null !== $request->file('image')) {
            $file = $request->file('image')->store('', 'public');

            $result = $service->updateImage($request, 'public', true, Options::venue_org_thumb_values());

            $any_venue['image'] = $result['image'];
            $any_venue['file_name'] = $request->file('image')->getClientOriginalName();
        }

        $any_venue->save();

        if (null !== $request->id) {
            $any_venue->member_agreements()->detach($request->id);
        }

        $any_venue->agreements()->attach($request->all_agreements);

        if (null !== ($request->file('attachments'))) {
            $result = $this->attachmentService->createAttachment($request, $any_venue);
            if ($result) {
                Session::flash('success', 'You uploaded '.count($request->file('attachments')).
                    Str::plural(' file', count($request->file('attachments'))));
            } else {
                Session::flash('error', 'You have an upload problem');
            }
        }

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
                if ($venue['image']) {
                    Storage::disk('public')->delete($venue['image']);
                    Storage::disk('public')->delete(Options::venue_org_thumb_values()['tn_str'].$venue['image']);
                }

                $venue->delete();
            });

        Session::flash('success', Str::plural(count($request->id).
                ' Venue', count($request->id)).' deleted.');

        return redirect()->route('venues_list');
    }
}
