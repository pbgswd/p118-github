<?php

namespace App\Http\Controllers;

use App\Http\Requests\Member\UpdateMember;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Models\Role;


/**
 * Class UserController
 * @package App\Http\Controllers
 */
class UserController extends Controller
{

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::with('user_info')->sortable()->orderBy('name')->paginate(20);
        return view('listusers', ['data'=>array('users'=>$users )]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $phone = $user->phone_number;
        $member_info = $user->user_info;
        $address = $user->address;
        $membership = $user->membership;
        //$currentUser = Auth::user(); // the logged in user, perms to edit?
        //$regions = $this->getFormOptions(['countries', 'statesprovs']);
        $roles = Role::get();
        $member_roles = $user->getRoleNames()->toArray();
        $member_roles = array_combine($member_roles, $member_roles);

        $data = [
            'user' => $user,
            'user_roles' => $member_roles,
            'user_info' => $member_info,
            'user_phone' => $phone,
            'user_address' => $address,
            'user_membership' => $membership,
            'roles' => $roles,
            //'currentUserPermissions' => $currentUser->permissions,
            //'countries' =>  $regions['countries'],
            //'provinces' =>   $regions['statesprovs']['Provinces'],
        ];

        return view('member', ['data'=> $data]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $member
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $user->phone_number;
        $user->user_info;
        $user->address;
        $user->membership;
        $currentUser = Auth::user(); // the logged in user, perms to edit?
        $regions = $this->getFormOptions(['countries', 'statesprovs']);
        $roles = Role::get();
        $user_roles = $user->getRoleNames()->toArray();
        $user_roles = array_combine($user_roles, $user_roles);

        $data = [
            'user' => $user,
            'user_roles' => $user_roles,
            'roles' => $roles,
            'action' => 'Edit',
            'currentUserPermissions' => $currentUser->permissions,
            'countries' =>  $regions['countries'],
            'provinces' =>   $regions['statesprovs']['Provinces'],
        ];

        return view('member_edit', ['data'=> $data]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMember $request, User $user)
    {
        Session::flash('success', "You have edited your profile");

        return redirect()->route('member_edit', [$user->id]);
    }

    protected function uploadImage(FormRequest $request)
    {
        $path = $request->file('image')->store('','users');
        return $path;
    }
}
