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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [];
        $data['organizations'] = Organization::sortable()->orderBy('name')->paginate(10);

        return view('admin.listorganizations', ['data' => array('data' => $data)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $org = new Organization();
        $org['user_id'] = Auth::id();
        $access_levels = $this->getFormOptions(['access_levels']);

        return view('admin.organization', ['data' => ['organization' => $org, 'access_levels' => $access_levels, 'action' => 'Create']]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Organization  $organization
     * @return \Illuminate\Http\Response
     */
    public function edit(Organization $organization)
    {
        $access_levels = $this->getFormOptions(['access_levels']);

        return view('admin.organization', ['data' => ['organization' => $organization, 'access_levels' => $access_levels, 'action' => 'Edit']]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Organization  $organization
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Organization $organization)
    {
        $organization->fill($request['organization']);
        $organization->save();

        Session::flash('success', "You have edited the organization");

        return redirect()->route('organization_edit', [$organization->slug]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Organization  $organization
     * @return \Illuminate\Http\Response
     */
    public function destroy(Organization $request)
    {

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
