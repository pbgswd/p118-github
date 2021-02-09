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

        $access = Auth::check() ? 'members' : 'public';

        $data['organizations'] = Organization::where([
                ['live', 1],
                ['access_level', $access],
            ])
            ->sortable()
            ->orderBy('sort_order')
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

       // dd($data);

        return view('organization', ['data' => $data]);
    }
}
