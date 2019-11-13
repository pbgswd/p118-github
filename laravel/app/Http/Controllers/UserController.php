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
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;


/**
 * Class UserController
 * @package App\Http\Controllers
 */
class UserController extends Controller
{
    use HasRoles;


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
        $user_info->image = $this->uploadImage($request);
        $user_info['file_name'] = $request->image->getClientOriginalName();

        $user->user_info()->save($user_info);

        $address = new Address($request->input('user_address'));
        $user->address()->save($address);

        $membership = new Membership($request->input('user_membership'));
        $user->membership()->save($membership);

        $user_roles = new Role($request->input('user_roles'));
        $user_roles->save();

        // send new user an email with login instructions.

        Session::flash('success', "You have saved a new member");

        return redirect()->route('user_edit', [$user->id]);
    }

    /**
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function edit(User $user)
    {
//dd(storage_path('app/users'));
        $phone = $user->phone_number;
        $user_info = $user->user_info;
        $address = $user->address;
        $membership = $user->membership;
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
     * @param UpdateUser $userRequest
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateUser $userRequest, User $user)
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

            if (isset( $user_info['delete_image'])) {
                Storage::disk('users')->delete($user_info['image']);

                Session::flash('info', "You have deleted " . $user_info['image']);
                $user_info['image'] = null;
                $user_info['file_name'] = null;
            } else {
                $user_info['image'] = $this->uploadImage($userRequest);
                $user_info['file_name'] = $userRequest->image->getClientOriginalName();
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

        $user->syncRoles($userRequest['user_roles']);

        if ($user->membership instanceof Membership) {
            $user->membership->fill($userRequest['user_membership']);
            $user->membership->save();
        } else {
            $membership = new Membership($userRequest['user_membership']);
            $user->membership()->save($membership);
        }

        Session::flash('success', "You have edited a member profile");

        return redirect()->route('user_edit', [$user->id]);
    }

    /**
     * @param DestroyUser $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(DestroyUser $request)
    {
        $users = User::find($request->id);

        foreach ($users as $user) {
            PhoneNumber::where('user_id', $user->id)->delete();
            Address::where('user_id', $user->id)->delete();
            Membership::where('user_id', $user->id)->delete();
            $user->syncRoles();
            $user_info = UserInfo::where('user_id', $user->id)->first();
            if ($user_info['image']) {
                Storage::disk('users')->delete($user_info['image']);
            }
            UserInfo::destroy($user_info['id']);
        }
        User::destroy($request->id);

        Session::flash('success', Str::plural('Member', count($request->id)) . ' deleted.');

        return redirect()->route('users_list');
    }

    protected function uploadImage(FormRequest $request)
    {
        $path = $request->file('image')->store('','users');
        return $path;

        /*
               if (!$request->image) {
                   return $request->input('user_info.image');
               }

              $imageName = $request->image->getClientOriginalName();

               if (!$request->image->storeAs('users', $imageName)) {
                   Session::flash('warning', "Did not store " . $imageName);

                   return null;
               }

               return $imageName;
        */
    }
}
