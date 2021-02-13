<?php

namespace App\Http\Controllers;

use App\Http\Requests\Member\UpdateMemberEmergencyContact;
use App\Http\Requests\User\DestroyUser;
use App\Http\Requests\User\StoreUser;
use App\Http\Requests\User\UpdateMemberAddress;
use App\Http\Requests\User\UpdateUser;
use App\Models\Executive;
use App\Models\ExecutiveMembership;
use App\Models\Membership;
use App\Models\Options;
use App\Models\PhoneNumber;
use App\Models\User;
use App\Models\UserInfo;
use App\Rules\Phone;
use App\Services\AttachmentService;
use App\Services\EmailMemberUpdateAddressService;
use App\Services\EmailMemberUpdateService;
use App\Services\UserImageService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Spatie\Image\Exceptions\InvalidManipulation;
use Spatie\Permission\Models\Role;

/**
 * Class AdminUserController.
 */
class AdminUserController extends Controller
{
    /**
     * @var EmailMemberUpdateService
     * @var UserImageService
     */
    private $emailMemberUpdateService;

    public function __construct(EmailMemberUpdateService $emailMemberUpdateService, UserImageService $userImageService)
    {
        $this->emailMemberUpdateService = $emailMemberUpdateService;
        $this->userImageService = $userImageService;
    }

    /**
     * @return View
     * @throws AuthorizationException
     */
    public function index(): View
    {
        $this->authorize('viewAny', Auth::user());

        $users = User::with(
            [
                'roles',
                'currentExecutiveRoles',
                'membership',
            ]
        )->sortable()
        ->paginate(20);

        $count = Membership::where('membership_type', 'Member')->count();

        return view('admin.listusers', ['data' => ['users' => $users, 'count' => $count]]);
    }

    /**
     * @return RedirectResponse
     */
    public function create(): RedirectResponse
    {
        Session::flash('warning', 'Create method blocked off. Contact admin for support.');

        return redirect()->route('users_list');

        /***************
                $this->authorize('create', Auth::user());

                $user = new User;
                $phone = new PhoneNumber;
                $user_info = new UserInfo;
                $address = new Address;
               // $membership = new Membership;

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
                    //'user_membership' => $membership,
                    'countries' => $regions['countries'],
                    'provinces' => $regions['statesprovs']['Provinces'],
                ];

                return view('admin.user', ['data' => $data]);
         * **/
    }

    /**
     * @param StoreUser $request
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function store(StoreUser $request): RedirectResponse
    {
        $this->authorize('create', Auth::user());
        Session::flash('warning', 'Store method blocked off. Contact admin for support.');

        return redirect()->route('users_list');
        /*******************

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

           //$membership = new Membership($request->input('user_membership'));
           //$user->membership()->save($membership);

           $user_roles = new Role($request->input('user_roles'));
           $user_roles->save();

           Session::flash('success', "You have saved a new member");

           return redirect()->route('user_edit', [$user->id]);
         * ***********/
    }

    /**
     * @param User $user
     * @return View
     * @throws AuthorizationException
     */
    public function edit(User $user, UserImageService $service): View
    {
        $this->authorize('admin_update', Auth::user());

        $user->load('phone_number',
                    'user_info',
                    'allExecutiveRoles',
                    'committee_memberships',
                    'membership'
                    );

        if($user->user_info) {
            if($user->user_info['image']) {
                if(file_exists(storage_path() . '/app/users/' . $user->user_info['image'])) {
                    $filesize = AttachmentService::human_filesize(
                    \filesize(\storage_path('app/users' . '/' . $user->user_info->image))) ? : null;

                    if(!file_exists(storage_path() . '/app/users/' . Options::thumb_values()['tn_str'] .
                        $user->user_info['image'])) {
                            $this->userImageService->generate_thumb($user->user_info['image'], 'users',
                                Options::thumb_values());
                    }
                }
                $user->user_info->thumb = Options::thumb_values()['tn_str'] . $user->user_info['image'];
                $user->user_info->thumb_size = AttachmentService::human_filesize(
                    \filesize(\storage_path('app/users' . '/' . $user->user_info->thumb))) ? : null;
            }
        }

        $user_roles = $user->getRoleNames()->toArray();

        $data = [
            'user' => $user,
            'membership' => Options::membership_levels(),
            'filesize' => $filesize ?? '',
            'executive_roles' => Executive::all(),
            'user_roles' => array_combine($user_roles, $user_roles),
            'roles' => Role::get(),
            'action' => 'Edit',
        ];

        return view('admin.user', ['data' => $data]);
    }

    /**
     * @param UpdateUser $request
     * @param UserImageService $service
     * @param User $user
     * @return RedirectResponse
     * @throws AuthorizationException
     * @throws InvalidManipulation
     */
    public function update(UpdateUser $request, UserImageService $service, User $user): RedirectResponse
    {
        $this->authorize('admin_update', Auth::user());

        $user->load('phone_number', 'membership');

        $message = [];
        $original_name = $user->name;

        if ($request->user['name'] != $user->name) {
            $message['Name'] = $request->user['name'];
        }

        if ($request->user['email'] != $user->email) {
            $message['Email'] = $request->user['email'];
        }

        $user->fill($request['user']);
        $user->save();
        $user->touch();

        if ($user->phone_number instanceof PhoneNumber) {
            if ($request->user_phone['phone_number'] != $user->phone_number->phone_number) {
                $message['Phone'] = $request->user_phone['phone_number'];
            }
            $user->phone_number->fill($request['user_phone']);
            $user->phone_number->save();
        } else {
            $phone = new PhoneNumber($request['user_phone']);
            $user->phone_number()->save($phone);
            $message['Phone'] = $request->user_phone['phone_number'];
        }

        if ($user->user_info instanceof UserInfo) {
            $user_info = $request['user_info'];

            if (isset($user_info['delete_image'])) {
                if(file_exists(storage_path() . '/app/users/' . $user_info['image'])) {

                    $this->userImageService->destroyImage($user_info['image'], 'users', Options::thumb_values());

                    Session::flash('info', 'You have deleted ' . $user_info['file_name']);
                    $user_info['image'] = null;
                    $user_info['file_name'] = null;
                }
            } else {
                if (!is_null($request->file('image'))) {

                    $result = $this->userImageService->updateImage($request, 'users', true);

                    $user_info['image'] = $result['image'];
                    $user_info['file_name'] = $result['file_name'];

                }
            }
            $user->user_info->fill($user_info);
            $user->user_info->save();
        } else {
            $user_info = new UserInfo($request->input('user_info'));
            if (null !== $request->file) {
                $user_info->image = $this->uploadImage($request);
            }
            $user->user_info()->save($user_info);
        }

        $user_roles = $user->getRoleNames()->toArray();

        if ($user_roles !== $request->user_roles) {
            $message['Website_Roles'] = implode(', ', $request->user_roles);
        }
        $user->syncRoles([$request->user_roles]);

        if ($user->membership instanceof Membership) {
            if ($request['user_membership']['membership_type'] != $user->membership->membership_type) {
                $message['Membership_type'] = $request['user_membership']['membership_type'];
            }
            $user->membership->fill($request['user_membership']);
            $user->membership->save();
        } else {
            $membership = new Membership($request['user_membership']);
            $user->membership()->save($membership);
            $message['Membership'] = $request['user_membership']['membership_type'];
        }

        if (! empty($message)) {
            $result = $this->emailMemberUpdateService->sendMessage($message, $user, $original_name);
        }

        Session::flash('success', 'You have edited a member profile');

        return redirect()->route('user_edit', [$user->id]);
    }


    /**
     * @param User $user
     * @return View
     * @throws AuthorizationException
     */
    public function admin_edit_address(User $user): View
    {
        $this->authorize('update', $user);

        $currentUser = Auth::user();
        $regions = $this->getFormOptions(['statesprovs']);

        $data = [
            'user' => $user,
            'action' => 'Edit',
            'currentUserPermissions' => $currentUser->permissions,
            'provinces' => $regions['statesprovs']['Provinces'],
        ];

        return view('admin.user-edit-address', ['data' => $data]);
    }

    /**
     * @param UpdateMemberAddress $userRequest
     * @param EmailMemberUpdateAddressService $service
     * @param User $user
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function admin_update_address(
        UpdateMemberAddress $userRequest,
        EmailMemberUpdateAddressService $service,
        User $user
    ): RedirectResponse
    {
        $this->authorize('update', $user);
        $message = [];

        $addr = ['unit', 'street', 'city', 'province', 'postal_code', 'message'];

        foreach ($addr as $k => $a) {
            if ($userRequest->$a) {
                if ($a == 'postal_code') {
                    $userRequest->$a = strtoupper($userRequest->$a);
                }
                $message[ucfirst($a)] = $userRequest->$a;
            }
        }

        if (! empty($message)) {
            $result = $service->sendMessage('Admin Address', $message, $user);
        }

        Session::flash('success', 'The member address update has been emailed to the office contacts.');

        return redirect()->route('admin_edit_address', $user->id);
    }

    /**
     * @param User $user
     * @return View
     * @throws AuthorizationException
     */
    public function admin_edit_emergency_contact(User $user): View
    {
        $this->authorize('update', $user);

        $currentUser = Auth::user();

        $data = [
            'user' => $user,
            'action' => 'Edit',
            'currentUserPermissions' => $currentUser->permissions,
        ];

        return view('admin.user-edit-emergency-contact', ['data' => $data]);
    }

    /**
     * @param UpdateMemberEmergencyContact $userRequest
     * @param EmailMemberUpdateAddressService $service
     * @param User $user
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function admin_update_emergency_contact(
        UpdateMemberEmergencyContact $userRequest,
        EmailMemberUpdateAddressService $service,
        User $user
    ): RedirectResponse
    {
        $this->authorize('update', $user);

        $userRequest->validate([
            'emergency_contact_phone' => ['required',
                new Phone()
            ]
        ]);

        $message = [];

        $fields = ['emergency_contact_name', 'emergency_contact_relationship', 'emergency_contact_phone', 'message'];

        foreach ($fields as $k => $a) {
            if ($userRequest->$a) {
                $message[ucfirst($a)] = $userRequest->$a;
            }
        }

        if (! empty($message)) {
            $result = $service->sendMessage('Admin Emergency Contact', $message, $user);
        }

        Session::flash('success', 'The emergency contact update has been emailed to the office recipients.');

        return redirect()->route('admin_edit_emergency_contact', $user->id);
    }


    /**
     * @param DestroyUser $request
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function destroy(DestroyUser $request): RedirectResponse
    {
        $this->authorize('delete', Auth::user());

        $users = User::find($request->id);

        //todo cannot delete user when user has a post, page, topic, or is a member of a committee.
        // Deal with this
        //todo user soft delete

        foreach ($users as $user) {
            $user_roles = $user->getRoleNames()->toArray();
            $user_roles = array_combine($user_roles, $user_roles);

            foreach ($user_roles as $r) {
                $user->removeRole($r);
            }

            PhoneNumber::where('user_id', $user->id)->delete();

            Membership::where('user_id', $user->id)->delete();

            $user_info = UserInfo::where('user_id', $user->id)->first();

            if(null != $user_info) {
                if ($user_info['image']) {
                    $this->userImageService->destroyImage($user_info['image'], 'users', Options::thumb_values());
                }
                UserInfo::destroy($user_info['id']);
            }

            $e = ExecutiveMembership::find($user->id);
            if (null != $e) {
                $e->delete();
            }

            $user->allExecutiveRoles()->detach();

            User::destroy($user->id);
        }

        Session::flash('success', Str::plural('Member', count($request->id)).' deleted.');

        return redirect()->route('users_list');
    }
}
