<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\DestroyUser;
use App\Http\Requests\User\StoreUser;
use App\Http\Requests\User\UpdateUser;
use App\Models\Address;
use App\Models\Membership;
use App\Models\PhoneNumber;
use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
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
     * @return Response
     */
    public function index(Request $request)
    {
        $users = User::with('roles')->sortable()->paginate(10);
        return view('admin.listusers', ['data'=>array('users'=>$users )]);
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $user = new User;
        $phone = new PhoneNumber;
        $user_info = new UserInfo;
        $address = new Address;
        $membership = new Membership;

        $regions = $this->getFormOptions(['countries', 'statesprovs']);
        $currentUser = Auth::user();

        $roles = Role::get();
        $user_roles = $user->getRoleNames()->toArray();
        $user_roles = array_combine($user_roles, $user_roles);

        $data = [
            'user' => $user,
            'user_roles' => $user_roles,
            'roles' => $roles,
            'action' => 'Create',
            'currentUserPermissions' => $currentUser->permissions,

            'user_info' => $user_info,
            'user_phone' => $phone,
            'user_address' => $address,
            'user_membership' => $membership,

            'countries' =>  $regions['countries'],
            'provinces' =>   $regions['statesprovs']['Provinces'],
        ];

        return view('admin.user', ['data'=> $data]);

        //return view('admin.user', ['data' => ['user' => $user, 'action' => 'Create']]);
    }

    /**
     * @param StoreUser $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreUser $request)
    {
        $user = new User($request->input('user'));

        $user->save();

        Session::flash('success', "You have saved a new member");

        return redirect()->route('user_edit', [$user->id]);
    }

    /**
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function edit(User $user, PhoneNumber $phoneNumber)
    {

        $user_phone = User::find(1)->phone_number;

        // user_info table

        // address table


        // membership table

        $currentUser = Auth::user(); // the logged in user, perms to edit?

        $regions = $this->getFormOptions(['countries', 'statesprovs']);

        $roles = Role::get();
        $user_roles = $user->getRoleNames()->toArray();
        $user_roles = array_combine($user_roles, $user_roles);


//cat1happy.png

        $user_info = [
            'image' => '',
            'share_image' => '1',
            'share_phone' => '1',
            'share_email' => '1',
            'about' => 'sdfasfaf',
        ];

        $user_address = [
            'unit' => '',
            'street' => '34242 xx street',
            'city' => 'chernobyl',
            'postal_code' => 'X1X 1X1',
            'province' => 'BC',
            'country' => 'Canada',
        ];

        $user_membership = [
            'membership_date' => '2017-01-30',
            'membership_expires' => '2020-01-01',
            'seniority_number' => '34234',
            'status' => 'member',
            'admin_notes' => 'test',
        ];

        $data = [
            'user' => $user,
            'user_roles' => $user_roles,
            'user_info' => $user_info,
            'user_phone' => $user_phone,
            'user_address' => $user_address,
            'user_membership' => $user_membership,
            'roles' => $roles,
            'action' => 'Edit',
            'currentUserPermissions' => $currentUser->permissions,
            'countries' =>  $regions['countries'],
            'provinces' =>   $regions['statesprovs']['Provinces'],
        ];

        return view('admin.user', ['data'=> $data]);
    }

    /**
     * @param UpdateUser $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateUser $request, User $user, PhoneNumber $phoneNumber)
    {

        $user->fill($request['user']);
        $user->save();

        $phoneNumber->fill($request['user_phone']);
        $phoneNumber->save();

        dd($request->all());

        // user_info table

        // address table

        // phone table (array of phone numbers eventually)

        // membership table



        Session::flash('success', "You have edited a member profile");

        return redirect()->route('user_edit', [$user->id]);
    }

    /**
     * @param DestroyUser $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(DestroyUser $request)
    {
       User::destroy($request->id);
       Session::flash('success', Str::plural('Member', count($request->id)) . ' deleted.');

       return redirect()->route('users_list');
    }
}
