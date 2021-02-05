<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class OrganizationController extends Controller
{
    /**
     * @return View
     */
    public function list(): View
    {
        $data = [];
        $data['organizations'] = Organization::sortable()
            ->orderBy('name')
            ->paginate(10);

        return view('organizations', ['data' => ['data' => $data]]);
    }

    /**
     * @param Organization $organization
     * @return View
     */
    public function show(Organization $organization): View
    {
        $data = [];

        $data['agreements'] = Auth::check() ? $organization->member_agreements :
            $organization->agreements;

        $data['organization'] = $organization;

        return view('organization', ['data' => $data]);
    }
}
