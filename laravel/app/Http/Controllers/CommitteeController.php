<?php

namespace App\Http\Controllers;

use App\Models\Committee;
use App\Models\CommitteePost;
use App\Models\Options;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CommitteeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $c = Committee::with('creator')->sortable()->paginate(10);

        /*
         * names and profile links to who are Chair, cochair, Secretary
         * logged in user is a member or not?
         * count of members
         * link to members list of this committee
         * list of posts, news
         * subscribe status, or unsubscribe
         */

        return view('committees', ['data' => ['committees' => $c]]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function join(Request $request, Committee $committee)
    {
        dd(Auth::id());
        // if you are already a member, dont allow
        // if you are  a past member, set to member
        // check if this person is a member before adding them

       // $user =

        dd(__METHOD__);
        $committee->committee_members()->attach(Auth::id(), ['role' => 'Member']);

        Session::flash('success', 'You have joined ' . $committee->name);

        return redirect()->route('committee', $committee->slug);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function leave(Request $request, Committee $committee)
    {
//dd(__METHOD__);
        // if you are already a member, dont allow
        // if you are  a past member, set to member

        $committee->committee_members->updateExistingPivot(Auth::id(), ['role' => 'Past-Member']);
        dd($committee->committee_members);
        Session::flash('success', 'You have left' . $committee->name);

        return redirect()->route('committee', $committee->slug);
    }


    /**
     * Display the specified resource.
     *
     * @param Committee $committee
     * @return Response
     */
    public function show(Committee $committee, CommitteePost $committeePost)
    {
        //todo order posts returned by date, latest first, pagination
        $committee->load('creator', 'committee_members', 'posts');

        $committee->postsCount = CommitteePost::where('committee_id', $committee->id)->count();

        $committee->posts = CommitteePost::where('committee_id', $committee->id)->orderByDesc('created_at')->paginate(5);
        //$committee->post_entries = $committee->posts->sortByDesc('created_at');

        $committee['committee_roles'] = Options::committee_roles();
        $committee_executive_roles = Options::committee_executive_roles();

        $committee['executives'] = $committee->committee_members->filter( function (User $user) use ($committee_executive_roles) {
            return in_array($user->pivot->role, $committee_executive_roles);
        })
        ->sortBy( function (User $user) use ($committee_executive_roles) {
            return array_search($user->pivot->role, $committee_executive_roles);
        });

        $data = ['committee' => $committee];

        $data['isMember'] = $committee->committee_members->contains(function (User $member) {
            return Auth::id() == $member->id;
        });

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
        /** get members for this committee
         *  get sortable thing
         *  get paginate thing
         *
         * do we use visibility preferences for users profile?
         * do we say if you are a member you have to show your email
         * do we say if you are a member you have to show your profile?
         * show member status? Chair, Co-chair, Secretary, Member
         */

        $committee->load('committee_members')->sortable()->paginate(2);

        return view('committee_list_members', ['data' => ['committee' => $committee]]);
    }


}
