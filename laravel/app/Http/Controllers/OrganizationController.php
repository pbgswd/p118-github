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
        $data['organizations'] = Organization::where('live', 1)
            ->whereIn('access_level', ['public', Auth::check() ? 'members' : ''])
            ->orderBy('name')
            ->paginate(9);

        $data['tn_prefix'] = Options::venue_org_thumb_values()['tn_str'];

        return view('organizations', ['data' => $data]);
    }

    /**
     * @param Organization $organization
     * @return View
     */
    public function show(Organization $organization): View
    {
        if ($organization['image']) {
            if (file_exists(storage_path() . '/app/public/' . $organization['image'])) {

                if (!file_exists(storage_path() . '/app/public/' . Options::venue_org_thumb_values()['tn_str'] .
                    $organization['image'])) {
                    $this->userImageService->generate_thumb($organization['image'], 'public',
                        Options::venue_org_thumb_values());
                }
            }
        }
        $organization->thumb = Options::venue_org_thumb_values()['tn_str'] . $organization['image'] ? : '';
        $organization->load('attachments');

        $data = [
            'organization' => $organization,
            'agreements' => Auth::check() ? $organization->member_agreements()->paginate(5) :
                $organization->agreements()->paginate(5),
        ];

        return view('organization', ['data' => $data]);
    }
}
