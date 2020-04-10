<?php

namespace App\Http\Controllers;

use App\Constants\AccessLevelConstants;
use App\Http\Requests\Organization\DestroyOrganizationRequest;
use App\Http\Requests\Organization\StoreOrganizationRequest;
use App\Http\Requests\Organization\UpdateOrganizationRequest;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class AdminOrganizationController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('viewAny', Auth::user());
        $data = [];
        $data['organizations'] = Organization::withoutGlobalScopes()->sortable()->orderBy('name')->paginate(10);

        return view('admin.listorganizations', ['data' => ['data' => $data]]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Auth::user());

        return view('admin.organization', [
            'data' => [
                'organization' => new Organization(),
                'access_levels' => array_combine(AccessLevelConstants::getConstants(),AccessLevelConstants::getConstants()),
                'action' => 'Create',
            ]
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreOrganizationRequest $request)
    {
        $this->authorize('create', Auth::user());
        $org = new Organization($request->organization);

        $org->save();

        Session::flash('success', "You have saved a new venue");

        return redirect()->route('organization_edit', [$org->slug]);
    }

    /**
     * @param Organization $any_organization
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Organization $any_organization)
    {
        $this->authorize('update', Auth::user());

        return view('admin.organization', ['data' => [
            'organization' => $any_organization,
            'access_levels' => array_combine(AccessLevelConstants::getConstants(),AccessLevelConstants::getConstants()),
            'action' => 'Edit',
            ]
        ]);
    }

    /**
     * @param UpdateOrganizationRequest $request
     * @param Organization $any_organization
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateOrganizationRequest $request, Organization $any_organization)
    {
        $this->authorize('update', Auth::user());
        $any_organization->fill($request->organization);
        $any_organization->save();

        Session::flash('success', "You have edited the organization");

        return redirect()->route('organization_edit', [$any_organization->slug]);
    }

    /**
     * @param DestroyOrganizationRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(DestroyOrganizationRequest $request)
    {
        $this->authorize('delete', Auth::user());
        Organization::withoutGlobalScopes()
            ->find($request->id)
            ->each(function (Organization $org) {
                $org->delete();
            }
        );

        Session::flash('success', Str::plural(count($request->id) . ' Organization', count($request->id)) . ' deleted.');

        return redirect()->route('organizations_list');
    }
}
