<?php

namespace App\Http\Controllers;

use App\Models\Policy;
use Illuminate\View\View;

class PolicyController extends Controller
{
    public function index(): View
    {
        $data = [];
        $data['policies'] = Policy::where('live', 1)
            ->sortable()
            ->with('attachments')
            ->orderBy('date', 'desc')
            ->paginate(30);

        $data['count'] = Policy::count();

        return view('policies_list', ['data' => ['data' => $data,
            'title' => 'Policies']]);
    }

    public function show(Policy $policy): View
    {
        $policy->load('user', 'attachments');

        $next = Policy::where('id', '>', $policy->id)
            ->where('live', 1)
            ->orderBy('id', 'asc')
            ->first();

        $previous = Policy::where('id', '<', $policy->id)
            ->where('live', 1)
            ->orderBy('id', 'desc')
            ->first();

        return view('policy_view', ['data' => [
            'policy' => $policy,
            'title' => $policy->title,
            'next' => $next,
            'previous' => $previous,
            ]
        ]);
    }
}
