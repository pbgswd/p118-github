<?php

namespace App\Http\Controllers;

use App\Models\Policy;
use Illuminate\View\View;

class PolicyController extends Controller
{
    public function index(): View
    {
        //$this->authorize('viewAny', Auth::user());
        $data = [];
        $data['policies'] = Policy::where('live', 1)
            ->sortable()
            ->with('attachments')
            ->orderBy('date', 'desc')
            ->paginate(10);

        $data['count'] = Policy::count();

        return view('policies_list', ['data' => ['data' => $data]]);
    }

    public function show(Policy $policy): View
    {
        $policy->load('user', 'attachments');

        return view('policy_view', ['data' => ['policy' => $policy]]);
    }
}
