<?php

namespace App\Http\Controllers;

use App\Models\Policy;
use Illuminate\View\View;

class PolicyController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        //$this->authorize('viewAny', Auth::user());
        $data = [];
        $data['policies'] = Policy::sortable()
            ->with('attachments')
            ->orderBy('date', 'desc')
            ->paginate(10);
        $data['count'] = Policy::count();

        return view('policies_list', ['data' => ['data' => $data]]);
    }

    /**
     * @param Policy $policy
     * @return View
     */
    public function show(Policy $policy): View
    {
        $policy->load('user', 'attachments');

        return view('policy_view', ['data' => ['policy' => $policy]]);
    }
}
