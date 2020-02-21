<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class OrganizationController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('viewAny', Auth::user());
        $data = [];
        $data['organizations'] = Organization::sortable()->orderBy('name')->paginate(10);

        return view('admin.listorganizations', ['data' => array('data' => $data)]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Auth::user());
        $org = new Organization();
        $org['user_id'] = Auth::id();
        $access_levels = $this->getFormOptions(['access_levels']);

        return view('admin.organization', ['data' => ['organization' => $org, 'access_levels' => $access_levels, 'action' => 'Create']]);

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request)
    {
        $this->authorize('create', Auth::user());
        $org = new Organization($request->input('organization'));
        $org->user_id = Auth::id();
        $org->save();

        Session::flash('success', "You have saved a new venue");

        return redirect()->route('organization_edit', [$org->slug]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Organization  $organization
     * @return \Illuminate\Http\Response
     */
    public function show(Organization $organization)
    {
        dd(__METHOD__);
    }

    /**
     * @param Organization $organization
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Organization $organization)
    {
        $this->authorize('update', Auth::user());
        $access_levels = $this->getFormOptions(['access_levels']);

        return view('admin.organization', ['data' => ['organization' => $organization, 'access_levels' => $access_levels, 'action' => 'Edit']]);

    }

    /**
     * @param Request $request
     * @param Organization $organization
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, Organization $organization)
    {
        $this->authorize('update', Auth::user());
        $organization->fill($request['organization']);
        $organization->save();

        Session::flash('success', "You have edited the organization");

        return redirect()->route('organization_edit', [$organization->slug]);
    }

    /**
     * @param Organization $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Organization $request)
    {
        $this->authorize('delete', Auth::user());
        $org = Organization::find($request->id);

        dd($org);

        /*       // dd($request->all());
                foreach($request as $r => $k)
                {
                    //dd($r[0]);
                    ->first();
                    dd($org);
                    Organization::destroy($org->id);
                }*/

        Session::flash('success', Str::plural(count($request) . ' Organization', count($request)) . ' NOT deleted.');

        return redirect()->route('organizations_list');
    }
}
