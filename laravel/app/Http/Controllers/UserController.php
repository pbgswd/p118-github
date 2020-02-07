<?php

namespace App\Http\Controllers;

use App\Http\Requests\Member\UpdateMember;
use App\Models\Address;
use App\Models\PhoneNumber;
use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
     * UserController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $users = User::with('user_info')->sortable()->orderBy('name')->paginate(20);
        return view('listusers', ['data' => array('users' => $users)]);
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return Response
     */
    public function show(User $user)
    {
        $user->load('committee_membership', 'phone_number', 'user_info', 'address', 'membership');
        //$currentUser = Auth::user(); // the logged in user, perms to edit?
        //$regions = $this->getFormOptions(['countries', 'statesprovs']);
        $roles = Role::get();
        $member_roles = $user->getRoleNames()->toArray();
        $member_roles = array_combine($member_roles, $member_roles);

        $data = [
            'user' => $user,
            'user_roles' => $member_roles,
            'roles' => $roles,
            //'currentUserPermissions' => $currentUser->permissions,
            //'countries' =>  $regions['countries'],
            //'provinces' =>   $regions['statesprovs']['Provinces'],
        ];
        //todo users roles, provinces, countries

        return view('member', ['data' => $data]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param User $member
     * @return Response
     */
    public function edit(User $user)
    {
        $user->load('phone_number', 'user_info', 'address', 'membership');
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
            'countries' => $regions['countries'],
            'provinces' => $regions['statesprovs']['Provinces'],
        ];

        return view('member_edit', ['data' => $data]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param User $user
     * @return Response
     */
    public function update(UpdateMember $userRequest, User $user)
    {
        $user->fill($userRequest['user']);
        $user->save();

        if ($user->phone_number instanceof PhoneNumber) {
            $user->phone_number->fill($userRequest['user_phone']);
            $user->phone_number->save();
        } else {
            $phone = new PhoneNumber($userRequest['user_phone']);
            $user->phone_number()->save($phone);
        }

        if ($user->user_info instanceof UserInfo) {
            $user_info = $userRequest['user_info'];

            if (isset($user_info['delete_image'])) {
                Storage::disk('users')->delete($user_info['image']);

                Session::flash('info', "You have deleted " . $user_info['image']);
                $user_info['image'] = null;
                $user_info['file_name'] = null;
            } else {
                if (!is_null($userRequest->file('image'))) {
                    $user_info['image'] = $this->uploadImage($userRequest);
                    $user_info['file_name'] = $userRequest->image->getClientOriginalName();
                }
            }
            $user->user_info->fill($user_info);
            $user->user_info->save();
        } else {
            $user_info = new UserInfo($userRequest->input('user_info'));
            $user_info->image = $this->uploadImage($userRequest);
            $user->user_info()->save($user_info);
        }
        if ($user->address instanceof Address) {
            $user->address->fill($userRequest['user_address']);
            $user->address->save();
        } else {
            $address = new Address($userRequest['user_address']);
            $user->address()->save($address);
        }

        /*
                $user->syncRoles($userRequest['user_roles']);

                if ($user->membership instanceof Membership) {
                    $user->membership->fill($userRequest['user_membership']);
                    $user->membership->save();
                } else {
                    $membership = new Membership($userRequest['user_membership']);
                    $user->membership()->save($membership);
                }
        */
//TODO notify office by email when user has updated contact information.
        Session::flash('success', "You have edited your profile");

        return redirect()->route('member_edit', [$user->id]);
    }

    protected function uploadImage(FormRequest $request)
    {
        $path = $request->file('image')->store('', 'users');
        return $path;
    }
}
