<?php

namespace App\Http\Controllers;

use App\Http\Requests\Organization\DestroyOrganizationRequest;
use App\Http\Requests\Organization\StoreOrganizationRequest;
use App\Http\Requests\Organization\UpdateOrganizationRequest;
use App\Models\Agreement;
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

        return view('admin.listorganizations', ['data' => $data]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Auth::user());

        $org = new Organization;
        $all_agreements = Agreement::withoutGlobalScopes()->orderBy('title')->get();

        return view(
            'admin.organization',
            [
                'data' => [
                    'organization' => $org,
                    'all_agreements' => $all_agreements,
                    'action' => 'Create',
                ],
            ]
        );
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

        $org->agreements()->sync($request->all_agreements);

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

        $any_organization->load('member_agreements');

        $all_agreements = Agreement::whereNotIn(
            'id',
            $any_organization->agreements->map(function (Agreement $agreement) {
                return $agreement->id;
            }))
            ->orderBy('title')->get();

        $any_organization->setRelation('all_agreements', $all_agreements);

        return view(
            'admin.organization',
            [
                'data' => [
                    'organization' => $any_organization,
                    'all_agreements' => $all_agreements,
                    'action' => 'Edit',
                ],
            ]
        );
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

        if(null !== $request->id) {
            $any_organization->agreements()->detach($request->id);
        }

        $any_organization->agreements()->attach($request->all_agreements);

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
            ->each(static function (Organization $org) {
                $org->delete();
            }
        );

        Session::flash('success', Str::plural(count($request->id) . ' Organization', count($request->id)) .
            ' deleted.');

        return redirect()->route('organizations_list');
    }
}
