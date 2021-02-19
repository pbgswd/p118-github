<?php

namespace App\Http\Controllers;

use App\Models\Options;
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

        $data['organizations'] = Organization::where('live', 1)
            ->whereIn('access_level', ['public', $access])
            ->paginate(10);

        $data['tn_prefix'] = Options::venue_org_thumb_values()['tn_str'];

        return view('organizations', ['data' => $data]);
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
