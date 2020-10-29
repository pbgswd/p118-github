<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class OrganizationController extends Controller
{
    /**
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function list()
    {
        $data = [];
        $data['organizations'] = Organization::sortable()
            ->orderBy('name')
            ->paginate(10);

        return view('organizations', ['data' => ['data' => $data]]);
    }

    /**
     * Display the specified resource.
     *
     * @param Organization $organization
     * @return Response
     */
    public function show(Organization $organization)
    {

        $data = [];

        $data['agreements'] = Auth::check() ? $organization->member_agreements :
            $organization->agreements;

        $data['organization'] = $organization;

        return view('organization', ['data' => $data]);
    }
}
