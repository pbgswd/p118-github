<?php

namespace App\Http\Controllers;

use App\Models\Committee;
use App\Models\CommitteePost;
use App\Models\Options;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class CommitteeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $c = Committee::with('creator', 'active_committee_members')
            ->sortable()
            ->paginate(10);

        /*
         * names and profile links to who are Chair, cochair, Secretary
         * logged in user is a member or not?
         * count of members
         * list of posts, news
         * subscribe status, or unsubscribe
         */

        return view('committees', ['data' => ['committees' => $c]]);
    }

    /**
     * @param Committee $committee
     * @return RedirectResponse
     */
    public function join(Committee $committee)
    {
        /*****
        $committee->load('committee_members');

        $data['isMember'] = $committee->committee_members
            ->contains(function (User $member) {
            return Auth::id() == $member->id;
        });

        if($data['isMember'] == true) {
            $committee->committee_members()
                ->updateExistingPivot(Auth::id(), ['role' => 'Member']);
        } else
        {
            $committee->committee_members()
                ->attach(Auth::id(), ['role' => 'Member']);
        }

        Session::flash('success', 'You have joined ' . $committee->name);

        return redirect()->route('committee', $committee->slug);
        ********/
    }

    /**
     * @param Committee $committee
     * @return RedirectResponse
     */
    public function leave(Committee $committee)
    {
        /**********
        $committee->committee_members()
            ->updateExistingPivot(Auth::id(), ['role' => 'Past-Member']);

        Session::flash('success', 'You have left' . $committee->name);

        return redirect()->route('committee', $committee->slug);
         * *******/
    }


    /**
     * @param Committee $committee
     * @return Application|Factory|View
     */
    public function show(Committee $committee)
    {
        $data = [];
        $data['committee'] = $committee->load('creator', 'active_committee_members');

        $data['sticky_posts'] = $committee->posts()
            ->with('creator')->where('sticky', 1)
            ->orderByDesc('updated_at');

        $data['posts'] = $committee->posts()
            ->with('creator')->where('sticky', '!=', 1)
            ->orderByDesc('updated_at')
            ->paginate(5);

        /** @var  User $user */
        $user = Auth::user();
        $user->committee_membership;

        $rank = \array_flip(\array_values(Options::committee_executive_roles()));

        $data['executives'] = $committee
            ->active_committee_members
            ->filter( static function (User $member) {
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

        return view('committee', ['data' => $data]);
    }

    /**
     * Display the specified resource.
     *
     * @param Committee $committee
     * @return Response
     */
    public function show_members(Committee $committee)
    {
        /**
         * do we use visibility preferences for users profile?
         * do we say if you are a member you have to show your email
         * do we say if you are a member you have to show your profile?
         * show member status? Chair, Co-chair, Secretary, Member


        $committee->load('active_committee_members')->sortable();

        return view('committee_list_members', ['data' => ['committee' => $committee]]);
        */
    }
}
