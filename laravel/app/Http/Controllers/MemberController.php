<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Member;
use Illuminate\Http\Request;
use App\Http\Requests\User\DestroyUser;
use App\Http\Requests\User\StoreUser;
use App\Http\Requests\User\UpdateUser;
use App\Models\Address;
use App\Models\PhoneNumber;
use App\Models\UserInfo;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;


class MemberController extends Controller
{
    use HasRoles;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = Member::with('user_info')->sortable()->orderBy('name')->paginate(20);
        return view('listusers', ['data'=>array('users'=>$users )]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(Member $member)
    {

        $phone = $member->phone_number;

        $member_info = $member->user_info;
        $address = $member->address;
        $membership = $member->membership;
        //$currentUser = Auth::user(); // the logged in user, perms to edit?
        //$regions = $this->getFormOptions(['countries', 'statesprovs']);
        $roles = Role::get();
        $member_roles = $member->getRoleNames()->toArray();
        $member_roles = array_combine($member_roles, $member_roles);

        $data = [
            'user' => $member,
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
    public function edit(Member $member)
    {
        $phone = $member->phone_number;
        $user_info = $member->user_info;
        $address = $member->address;
        $membership = $member->membership;
        $currentUser = Auth::user(); // the logged in user, perms to edit?
        $regions = $this->getFormOptions(['countries', 'statesprovs']);
        $roles = Role::get();
        $user_roles = $member->getRoleNames()->toArray();
        $user_roles = array_combine($user_roles, $user_roles);

        $data = [
            'user' => $member,
            'user_roles' => $user_roles,
            'user_info' => $user_info,
            'user_phone' => $phone,
            'user_address' => $address,
            'user_membership' => $membership,
            'roles' => $roles,
            'action' => 'Edit',
            'currentUserPermissions' => $currentUser->permissions,
            'countries' =>  $regions['countries'],
            'provinces' =>   $regions['statesprovs']['Provinces'],
        ];
        dd($data);
        //return view('member_edit', ['data'=> $data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
