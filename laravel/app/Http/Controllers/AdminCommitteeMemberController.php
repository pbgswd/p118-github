<?php

namespace App\Http\Controllers;

use App\Models\Committee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;


class AdminCommitteeMemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request, Committee $committee)
    {
        $users = User::sortable()->with('committee_membership')->paginate(20);

        $data = [];
        $data['users'] = $users->map(function ($user) use ($committee) {
            $info = $user->toArray();
            $info['isMember'] = $user->committee_membership->contains(function (Committee $membership) use ($committee) {
                return $membership->slug == $committee->slug;
            });
            return $info;
        });

        $data['committee'] = $committee;
        $data['committee_roles'] = $this->getFormOptions(['committee_roles']);

        return view('admin.committeebulkaddusers', ['data' => $data, 'users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request, Committee $committee)
    {
        foreach ($request->members as $member) {
           $committee->committee_members()->attach($member['id'], ['role' => $member['role']]);
        }

        Session::flash('success', "You have added " . count($request->members) . " members to committee " . $committee->name);
        return redirect()->route('list-bulk-add', $request->committee['slug']);
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param User $user
     * @return Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return Response
     */
    public function destroy(User $user)
    {
        //
    }

}
