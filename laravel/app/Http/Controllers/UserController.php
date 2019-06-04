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
use Illuminate\Foundation\Http\FormRequest;
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

    }

    /**
     * @param StoreUser $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreUser $request)
    {

        $user = new User(array_merge($request->input('user'), ['password' => bcrypt('secret')]) );
        $user->save();

        $phone = new PhoneNumber($request->input('user_phone'));
        $user->phone_number()->save($phone);

        $user_info = new UserInfo($request->input('user_info'));

// file upload
        $user_info->image = $this->uploadImage($request);

        $user->user_info()->save($user_info);

        $address = new Address($request->input('user_address'));
        $user->address()->save($address);

        $membership = new Membership($request->input('user_membership'));
        $user->membership()->save($membership);

        //$user_roles = new Role($request->input('user_roles'));
        //$user_roles->save();

        // send new user an email with login instructions.

        Session::flash('success', "You have saved a new member");

        return redirect()->route('user_edit', [$user->id]);
    }

    /**
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function edit(User $user, PhoneNumber $phoneNumber, UserInfo $user_info, Address $address, Membership $membership)
    {

        $phone = User::find(1)->phone_number;
        $user_info = User::find(1)->user_info;
        $address = User::find(1)->address;
        $membership = User::find(1)->membership;

        $currentUser = Auth::user(); // the logged in user, perms to edit?

        $regions = $this->getFormOptions(['countries', 'statesprovs']);

        $roles = Role::get();
        $user_roles = $user->getRoleNames()->toArray();
        $user_roles = array_combine($user_roles, $user_roles);

        $data = [
            'user' => $user,
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

        return view('admin.user', ['data'=> $data]);
    }

    /**
     * @param UpdateUser $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateUser $request, User $user, PhoneNumber $phoneNumber, UserInfo $user_info, Address $address, Role $user_roles, Membership $membership)
    {
        $user->fill($request['user']);
        $user->save();
        $phoneNumber->fill($request['user_phone']);
        $phoneNumber->save();
        $user_info->fill($request->input('user_info'));
        $user_info->save();
        $address->fill($request->input('user_address'));
        $address->save();

//        $user_roles->fill($request->input('user_roles'));
//        $user_roles->save();

        $membership->fill($request->input('user_membership'));
        $membership->save();

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

       /*
        * phone
        * user_info
        * address
        * role
        * membership
        */

       // revise count of membership seniority number

       Session::flash('success', Str::plural('Member', count($request->id)) . ' deleted.');

       return redirect()->route('users_list');
    }

    protected function uploadImage(FormRequest $request)
    {
        if (!$request->image) {
            return null;
        }

        $imageName = $request->image->getClientOriginalName();

        if (!$request->image->storeAs('public', $imageName)) {
            Session::flash('warning', "Did not store " . $imageName);

            return null;
        }

        return $imageName;
    }
}
