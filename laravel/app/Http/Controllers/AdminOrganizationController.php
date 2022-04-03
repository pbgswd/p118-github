<?php

namespace App\Http\Controllers;

use App\Http\Requests\Organization\DestroyOrganizationRequest;
use App\Http\Requests\Organization\StoreOrganizationRequest;
use App\Http\Requests\Organization\UpdateOrganizationRequest;
use App\Models\Agreement;
use App\Models\Options;
use App\Models\Organization;
use App\Services\AttachmentService;
use App\Services\UserImageService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminOrganizationController extends Controller
{
    /**
     * @var UserImageService
     */
    private $userImageService;

    public function __construct(UserImageService $userImageService, AttachmentService $attachmentService)
    {
        $this->userImageService = $userImageService;
        $this->attachmentService = $attachmentService;
    }

    /**
     * @return View
     * @throws AuthorizationException
     */
    public function index(): View
    {
        $this->authorize('viewAny', Organization::class);
        $data = [];
        $data['organizations'] = Organization::withoutGlobalScopes()->with('attachments', 'all_agreements')
            ->sortable()
            ->orderBy('name')
            ->paginate(10);

        return view('admin.listorganizations', ['data' => $data]);
    }

    /**
     * @return View
     * @throws AuthorizationException
     */
    public function create(): View
    {
        $this->authorize('create', Organization::class);

        $org = new Organization;
        $all_agreements = Agreement::withoutGlobalScopes()->orderBy('title')->get();

        $data = [
            'organization' => $org,
            'all_agreements' => $all_agreements,
            'action' => 'Create',
            'access_levels' => Options::access_levels(),
        ];

        return view('admin.organization', ['data' => $data]);
    }

    /**
     * @param StoreOrganizationRequest $request
     * @param UserImageService $service
     * @return RedirectResponse
     * @throws AuthorizationException
     * @throws \Spatie\Image\Exceptions\InvalidManipulation
     */
    public function store(StoreOrganizationRequest $request): RedirectResponse
    {
        $this->authorize('create', Organization::class);
        $org = new Organization($request->organization);

        if (null !== $request->file('image')) {
            $file = $request->file('image')->store('', 'public');
            $result = $this->userImageService->updateImage($request, 'public', true, Options::venue_org_thumb_values());
            $org['image'] = $result['image'];
            $org['file_name'] = $request->file('image')->getClientOriginalName();
        }

        $org->save();

        if (null !== ($request->file('attachments'))) {
            $result = $this->attachmentService->createAttachment($request, $org);
            if ($result) {
                Session::flash('success', 'You uploaded '.count($request->file('attachments')).
                    Str::plural(' file', count($request->file('attachments'))));
            } else {
                Session::flash('error', 'You have an upload problem');
            }
        }

        $org->agreements()->sync($request->all_agreements);

        Session::flash('success', 'You have saved a new venue');

        return redirect()->route('organization_edit', [$org->slug]);
    }

    /**
     * @param Organization $any_organization
     * @return View
     * @throws AuthorizationException
     * @throws \Spatie\Image\Exceptions\InvalidManipulation
     */
    public function edit(Organization $any_organization): View
    {
        $this->authorize('update', Organization::class);

        $any_organization->load('attachments');

        if ($any_organization['image']) {
            if (file_exists(storage_path().'/app/public/'.$any_organization['image'])) {
                $any_organization->filesize = AttachmentService::human_filesize(
                    \filesize(\storage_path('app/public'.'/'.$any_organization->image))) ?: null;

                if (! file_exists(storage_path().'/app/public/'.Options::venue_org_thumb_values()['tn_str'].
                    $any_organization['image'])) {
                    $this->userImageService->generate_thumb($any_organization['image'], 'public',
                        Options::venue_org_thumb_values());
                }
            }
            $any_organization->thumb = Options::venue_org_thumb_values()['tn_str'].$any_organization['image'];
            $any_organization->thumb_size = AttachmentService::human_filesize(
                \filesize(\storage_path('app/public'.'/'.$any_organization->thumb))) ?: null;
        }

        $all_agreements = Agreement::whereNotIn(
            'id',
            $any_organization->agreements->map(function (Agreement $agreement) {
                return $agreement->id;
            }))
            ->orderBy('title')->get();

        $any_organization->setRelation('all_agreements', $all_agreements);

        $data = [
            'organization' => $any_organization,
            'all_agreements' => $all_agreements,
            'action' => 'Edit',
            'access_levels' => Options::access_levels(),
        ];

        return view('admin.organization', ['data' => $data]);
    }

    /**
     * @param UpdateOrganizationRequest $request
     * @param Organization $any_organization
     * @return RedirectResponse
     * @throws AuthorizationException
     * @throws \Spatie\Image\Exceptions\InvalidManipulation
     */
    public function update(UpdateOrganizationRequest $request, Organization $any_organization): RedirectResponse
    {
        // dd($request->all());
        $this->authorize('update', Organization::class);
        $any_organization->fill($request->organization);

        if (isset($request['delete_image'])) {
            if (file_exists(storage_path().'/app/public/'.$any_organization['image'])) {
                $this->userImageService->destroyImage($any_organization['image'], 'public',
                    Options::venue_org_thumb_values());

                Session::flash('info', 'You have deleted '.$any_organization['file_name']);
                $any_organization['image'] = null;
                $any_organization['file_name'] = null;
            }
        }

        if (null !== $request->file('image')) {
            $file = $request->file('image')->store('', 'public');

            $result = $this->userImageService->updateImage($request, 'public', true, Options::venue_org_thumb_values());

            $any_organization['image'] = $result['image'];
            $any_organization['file_name'] = $request->file('image')->getClientOriginalName();
        }

        $any_organization->save();

        if (null !== $request->id) {
            $any_organization->agreements()->detach($request->id);
        }

        $any_organization->agreements()->attach($request->all_agreements);

        $result = $this->attachmentService->updateAttachment($request, $any_organization);

        if (null !== ($request->file('attachments'))) {
            $result = $this->attachmentService->createAttachment($request, $any_organization);
            if ($result) {
                Session::flash('success', 'You uploaded '.
                    count($request->file('attachments')).' files');
            } else {
                Session::flash('error', 'You have an upload problem');
            }
        }

        Session::flash('success', 'You have edited the organization');

        return redirect()->route('organization_edit', [$any_organization->slug]);
    }

    /**
     * @param DestroyOrganizationRequest $request
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function destroy(DestroyOrganizationRequest $request): RedirectResponse
    {
        $this->authorize('delete', Organization::class);

        Organization::withoutGlobalScopes()
            ->find($request->id)
            ->each(static function (Organization $org) {
                if ($org['image']) {
                    Storage::disk('public')->delete($org['image']);
                    Storage::disk('public')->delete(Options::venue_org_thumb_values()['tn_str'].$org['image']);
                    //$this->userImageService->destroyImage($feature['image'], 'public',
                    // Options::feature_thumb_values());
                }
                $org->delete();
            }
        );

        Session::flash('success', Str::plural(count($request->id).' Organization', count($request->id)).
            ' deleted.');

        return redirect()->route('organizations_list');
    }
}
