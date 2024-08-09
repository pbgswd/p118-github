<?php

namespace App\Http\Controllers;

use App\Models\Committee;
use App\Models\Options;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class CommitteeController extends Controller
{
    public function index(): View
    {
        $c = Committee::with('creator', 'active_committee_members')
            ->where('live', 1)
            ->sortable()
            ->paginate(10);

        return view('committees', ['data' => ['committees' => $c, 'title' => 'Committees']]);
    }

    public function show(Committee $committee): View
    {
        $data = [];
        $data['committee'] = $committee->load('creator', 'active_committee_members');

        $data['posts'] = $committee->posts()
            ->with('creator')
            ->where('sticky', '=', 0)
            ->orderByDesc('updated_at')
            ->paginate(10);

        $data['sticky_posts'] = $committee->posts()
            ->with('creator')
            ->where('sticky', '=', 1)
            ->orderByDesc('updated_at')->get();

        /** @var User $user */
        $user = Auth::user();

        $rank = \array_flip(\array_values(Options::committee_executive_roles()));

//todo something in this assignment is causing a deprecated error
//uasort(): Returning bool from comparison function is deprecated, return an integer less than, equal to, or greater than zero in /var/www/project118/laravel/vendor/laravel/framework/src/Illuminate/Collections/Collection.php
        $data['executives'] = $committee
            ->active_committee_members
            ->filter(static function (User $member) {
                return \in_array($member->pivot->role, Options::committee_executive_roles());
            })->sort(function ($a, $b) use ($rank) {
                return $rank[$a->pivot->role] > $rank[$b->pivot->role];
            });

        $data['isMember'] = $user
            ->committee_memberships
            ->filter(function (Committee $user_committee) use ($committee) {
                return $user_committee->slug == $committee->slug
               && $user_committee->pivot->role != 'Past-Member';
            })->isNotEmpty();

            $data['title'] = $committee->name;
        return view('committee', ['data' => $data]);
    }
}
