<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\DestroyUser;
use App\Http\Requests\User\StoreUser;
use App\Http\Requests\User\UpdateUser;
use App\Models\Address;
use App\Models\Executive;
use App\Models\Membership;
use App\Models\PhoneNumber;
use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;


/**
 * Class AdminUserController
 * @package App\Http\Controllers
 */
class AdminUserController extends Controller
{

    /**
     * @param Request $request
     * @return Factory|View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Auth::user());

        $users = User::with('roles')->sortable()->paginate(20);
        return view('admin.listusers', ['data' => ['users' => $users]]);
    }

    /**
     * @return Factory|View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        Session::flash('warning', 'Create method blocked off. Contact admin for support.');

        return redirect()->route('users_list');
        exit();

        $this->authorize('create', Auth::user());

        $user = new User;
        $phone = new PhoneNumber;
        $user_info = new UserInfo;
        $address = new Address;
        $membership = new Membership;

        $regions = $this->getFormOptions(['countries', 'statesprovs']);
        $currentUser = Auth::user();

        $roles = Role::get();

        $user_roles = ['member' => 'member'];

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
            'countries' => $regions['countries'],
            'provinces' => $regions['statesprovs']['Provinces'],
        ];

        return view('admin.user', ['data' => $data]);
    }

    /**
     * @param StoreUser $request
     * @return RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreUser $request)
    {
        $this->authorize('create', Auth::user());

//todo is password here just encrypting the word 'secret'?
//todo create default password for new user based on name and other data
//todo do not allow user to keep first password on signup.
//todo a fake password, then leverage password reset to send out login access

        $user = new User(array_merge($request->input('user'), ['password' => bcrypt('secret')]));
        $user->save();

        $phone = new PhoneNumber($request->input('user_phone'));
        $user->phone_number()->save($phone);

        $user_info = new UserInfo($request->input('user_info'));
        $user_info->image = $this->uploadImage($request);

        if(null !== $request->file) {
            $user_info['file_name'] = $request->image->getClientOriginalName() ?? '';
        }

        $user->user_info()->save($user_info);

        $address = new Address($request->input('user_address'));
        $user->address()->save($address);

        $membership = new Membership($request->input('user_membership'));
        $user->membership()->save($membership);

        $user_roles = new Role($request->input('user_roles'));
        $user_roles->save();

        // send new user an email with login instructions.

        //todo something like password reset to send out login information

        Session::flash('success', "You have saved a new member");

        return redirect()->route('user_edit', [$user->id]);
    }

    /**
     * @param User $user
     * @return Factory|View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */

    public function edit(User $user)
    {
        $this->authorize('admin_update', Auth::user());

        $user->load('phone_number', 'user_info',
                    'address', 'membership',
                    'allExecutiveRoles',
        );


        $currentUser = Auth::user(); // the logged in user, perms to edit? // dd(Auth::user()->permissions);

        $regions = $this->getFormOptions(['countries', 'statesprovs']);
        $roles = Role::get();
        $user_roles = $user->getRoleNames()->toArray();
        $user_roles = array_combine($user_roles, $user_roles);

        $data = [
            'user' => $user,
            'executive_roles' => Executive::all(),
            'user_roles' => $user_roles,
            'roles' => $roles,
            'action' => 'Edit',
            'currentUserPermissions' => $currentUser->permissions,
            'countries' => $regions['countries'],
            'provinces' => $regions['statesprovs']['Provinces'],
        ];

        return view('admin.user', ['data' => $data]);
    }

    /**
     * @param UpdateUser $userRequest
     * @param User $user
     * @return RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateUser $userRequest, User $user)
    {
        $this->authorize('admin_update', $user);
//TODO send email to office when user updates contact information

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

            if(null !== $userRequest->file) {
                $user_info->image = $this->uploadImage($userRequest);
            }
            $user->user_info()->save($user_info);
        }

        if ($user->address instanceof Address) {
            $user->address->fill($userRequest['user_address']);
            $user->address->save();
        } else {
            $address = new Address($userRequest['user_address']);
            $user->address()->save($address);
        }

        $user->syncRoles($userRequest['user_role']);

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
     * @return RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(DestroyUser $request)
    {
        $this->authorize('delete', Auth::user());

        // NOTE: $request->id is an array
        $users = User::find($request->id);

        //todo cannot delete user when user has a post, page, topic, or is a member of a committee.
        // Deal with this
//todo user soft delete
        foreach ($users as $user)
        {
            $user_roles = $user->getRoleNames()->toArray();
            $user_roles = array_combine($user_roles, $user_roles);

            foreach ($user_roles as $r)
            {
                $user->removeRole($r);
            }
//todo delete executive relation

            PhoneNumber::where('user_id', $user->id)->delete();
            Address::where('user_id', $user->id)->delete();
            Membership::where('user_id', $user->id)->delete();

            $user_info = UserInfo::where('user_id', $user->id)->first();
            if ($user_info['image']) {
                Storage::disk('users')->delete($user_info['image']);
            }

            UserInfo::destroy($user_info['id']);

            User::destroy($user->id);
        }

        Session::flash('success', Str::plural('Member', count($request->id)) . ' deleted.');

        return redirect()->route('users_list');
    }

    protected function uploadImage(FormRequest $request)
    {
        if (null !== $request->file('image')) {
            return $request->file('image')->store('', 'users');
        }

        return null;
    }
}
