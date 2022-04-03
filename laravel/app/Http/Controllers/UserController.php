<?php

namespace App\Http\Controllers;

use App\Http\Requests\InviteUser\ProcessUserRequest;
use App\Http\Requests\Member\UpdateMember;
use App\Http\Requests\Member\UpdateMemberEmergencyContact;
use App\Http\Requests\User\UpdateMemberAddress;
use App\Models\Executive;
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
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Spatie\Image\Exceptions\InvalidManipulation;
use Spatie\Permission\Models\Role;

/**
 * Class UserController.
 */
class UserController extends Controller
{
    /**
     * @var EmailMemberUpdateService
     * @var UserImageService
     */
    private $emailMemberUpdateService;

    /**
     * @var UserImageService
     */
    private $userImageService;

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
        $this->authorize('view', Auth::user());

        $users = User::with(['user_info', 'phone_number', 'currentExecutiveRoles', 'membership', 'committee_memberships'])
            ->sortable()
            ->orderBy('name')
            ->paginate(20);

        $count = Membership::where('membership_type', 'Member')->count();

        return view('listusers', ['data' => ['users' => $users, 'count' => $count]]);
    }

    /**
     * @param User $user
     * @return View
     * @throws AuthorizationException
     * @throws InvalidManipulation
     */
    public function show(User $user, UserImageService $service): View
    {
        $this->authorize('view', $user);

        $user->load('committee_memberships', 'phone_number',
                    'user_info', 'membership',
                    'allExecutiveRoles');

        $member_roles = $user->getRoleNames()->toArray();
        $member_roles = array_combine($member_roles, $member_roles);

        $folder = $user->getAttachmentFolder();
        $tn_prefix = Options::member_thumb_values()['tn_str'];

        if ($user->user_info['image']) {
            if (file_exists(storage_path().'/app/'.$folder.'/'.$user->user_info['image'])) {
                if (! file_exists(storage_path().'/app/'.$folder.'/'.$tn_prefix.$user->user_info['image'])) {
                    $service->generate_thumb($user->user_info['image'], $folder,
                        Options::member_thumb_values());
                }
            }
            $user->user_info->thumb = $tn_prefix.$user->user_info['image'];
        }

        $data = [
            'user' => $user,
            'user_roles' => $member_roles,
            'folder' => $folder,
            'tn_prefix' => $tn_prefix,
        ];

        return view('member', ['data' => $data]);
    }

    /**
     * @param User $user
     * @return View
     * @throws AuthorizationException
     * @throws InvalidManipulation
     */
    public function edit(User $user): View
    {
        $this->authorize('update', $user);

        $user->load('phone_number', 'user_info', 'membership', 'committee_memberships', 'allExecutiveRoles');

        if ($user->user_info) {
            if ($user->user_info['image']) {
                if (file_exists(storage_path().'/app/users/'.$user->user_info['image'])) {
                    $filesize = AttachmentService::human_filesize(
                        \filesize(\storage_path('app/users'.'/'.$user->user_info->image))) ?: null;

                    if (! file_exists(storage_path().'/app/users/'.Options::member_thumb_values()['tn_str'].
                        $user->user_info['image'])) {
                        $this->userImageService->generate_thumb($user->user_info['image'], 'users',
                            Options::member_thumb_values());
                    }
                }
                $user->user_info->thumb = Options::member_thumb_values()['tn_str'].$user->user_info['image'];
                $user->user_info->thumb_size = AttachmentService::human_filesize(
                    \filesize(\storage_path('app/users'.'/'.$user->user_info->thumb))) ?: null;
            }
        }

        $currentUser = Auth::user();
        $roles = Role::get();
        $user_roles = $user->getRoleNames()->toArray();
        $user_roles = array_combine($user_roles, $user_roles);
        $folder = $user->getAttachmentFolder();

        $data = [
            'user' => $user,
            'filesize' => $filesize ?? '',
            'user_roles' => $user_roles,
            'roles' => $roles,
            'action' => 'Edit',
            'currentUserPermissions' => $currentUser->permissions,
            'folder' => $folder,
            'tn_prefix' => Options::member_thumb_values()['tn_str'],
        ];

        return view('member_edit', ['data' => $data]);
    }

    /**
     * @param UpdateMember $userRequest
     * @param UserImageService $service
     * @param User $user
     * @return RedirectResponse
     * @throws AuthorizationException
     * @throws InvalidManipulation
     */
    public function update(UpdateMember $userRequest, UserImageService $service, User $user): RedirectResponse
    {
        $this->authorize('update', $user);

        $user->load('phone_number');

        /** @var array $message */
        $message = [];

        if ($userRequest->user['email'] != $user->email) {
            //todo forbid change to admin role email unless you already have that association

            $user->load('currentExecutiveRoles');

            $execEmails = Executive::pluck('email')->toArray();

            if (in_array($userRequest->user['email'], $execEmails)) {
                // dd('user wants to change email to '. $userRequest->user['email']);

                /**
                 * if user already has an exec email associated with him
                 * allow user to change email to exec email
                 *
                 * ??  decorator pattern
                 */
            }

            $message['Email'] = $userRequest->user['email'];
        }

        $user->fill($userRequest['user']);
        $user->save();
        $user->touch();

        if ($userRequest->user_phone['phone_number'] != '') {
            $userRequest->validate([
                'user_phone.phone_number' => [new Phone()],
            ]);
        }

        $user_phone_info = $userRequest->user_phone;
        $user_phone_info['phone_number'] = $userRequest->user_phone['phone_number'] ?? '';

        if ($user->phone_number instanceof PhoneNumber) {
            if ($user_phone_info['phone_number'] != $user->phone_number['phone_number']) {
                $message['Phone'] = trim($user_phone_info['phone_number']) != ''
                    ? $user_phone_info['phone_number'] : 'number deleted';
            }
            $user->phone_number->fill($user_phone_info);
            $user->phone_number->save();
        } else {
            $phone = new PhoneNumber($userRequest['user_phone']);
            $user->phone_number()->save($phone);
            $message['Phone'] = $user_phone_info['phone_number'] == ''
                ? $user_phone_info['phone_number'] : 'number deleted';
        }

        $folder = $user->getAttachmentFolder();
        $thumb_vals = Options::member_thumb_values();

        if ($user->user_info instanceof UserInfo) {
            $user_info = $userRequest['user_info'];
            if (isset($user_info['delete_image'])) {
                if (file_exists(storage_path().'/app/'.$folder.'/'.$user_info['image'])) {
                    $service->destroyImage($user_info['image'], $folder, $thumb_vals);

                    Session::flash('info', 'You have deleted '.$user_info['file_name']);

                    $user_info['image'] = null;
                    $user_info['file_name'] = null;
                }
            } else {
                if (! is_null($userRequest->file('image'))) {
                    $result = $service->updateImage($userRequest, $folder, true, $thumb_vals);

                    $user_info['image'] = $result['image'];
                    $user_info['file_name'] = $result['file_name'];

                    if (! file_exists(storage_path().'/app/'.$folder.'/'.$thumb_vals['tn_str'].
                        $user_info['image'])) {
                        $service->generate_thumb($user_info['image'], $folder, $thumb_vals);
                    }
                }
            }
            $user->user_info->fill($user_info);
            $user->user_info->save();
        } else {
            $user_info = new UserInfo($userRequest->input('user_info'));

            $result = $service->updateImage($userRequest, 'users', true);

            $user_info->image = $result['image'];

            $user->user_info()->save($user_info);

            if (! file_exists(storage_path().'/app/'.$folder.'/'.$thumb_vals['tn_str']
                .$user->user_info['image'])) {
                $service->generate_thumb($user->user_info['image'], $folder, $thumb_vals);
            }
        }

        if (! empty($message)) {
            Log::debug($user->name.' updated their profile, sending email at  '.date('Y-m-d H:i:s'));

            $message['email'] = $user->email;
            $message['name'] = $user->name;
            $result = $this->emailMemberUpdateService->sendMessage($message, $user);
        }

        Session::flash('success', 'Profile for '.$user->name.
            ' has been edited. The office will be updated with any changes.');

        return redirect()->route('member_edit', $user->id);
    }

    /**
     * @param User $user
     * @return View
     * @throws AuthorizationException
     */
    public function edit_address(User $user): View
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

        return view('member_address_edit', ['data' => $data]);
    }

    /**
     * @param UpdateMemberAddress $userRequest
     * @param EmailMemberUpdateAddressService $service
     * @param User $user
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function update_address(
       UpdateMemberAddress $userRequest,
       EmailMemberUpdateAddressService $service,
       User $user
    ): RedirectResponse {
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
            $result = $service->sendMessage('Member Address', $message, $user);
        }

        Session::flash('success', 'Your address update has been emailed to the office.');

        return redirect()->route('member_address_edit', $user->id);
    }

    public function edit_password(User $user): View
    {
        $this->authorize('update', $user);

        $data['action'] = 'Edit';
        $data['user'] = $user;

        return view('member_password_edit', ['data' => $data]);
    }

    public function update_password(ProcessUserRequest $request, User $user): RedirectResponse
    {
        $this->authorize('update', $user);

        $user->fill(['password' => bcrypt($request->password)]);
        $user->save();

        Log::debug($user->name.' updated their password at  '.date('Y-m-d H:i:s'));

        Session::flash('success', 'Your password has been updated.');

        return redirect()->route('member_password_edit', $user->id);
    }

    /**
     * @param User $user
     * @return View
     * @throws AuthorizationException
     */
    public function edit_emergency_contact(User $user): View
    {
        $this->authorize('update', $user);

        $currentUser = Auth::user();

        $data = [
            'user' => $user,
            'action' => 'Edit',
            'currentUserPermissions' => $currentUser->permissions,
        ];

        return view('member_emergency_edit', ['data' => $data]);
    }

    /**
     * @param UpdateMemberEmergencyContact $userRequest
     * @param EmailMemberUpdateAddressService $service
     * @param User $user
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function update_emergency_contact(
        UpdateMemberEmergencyContact $userRequest,
        EmailMemberUpdateAddressService $service,
        User $user
    ): RedirectResponse {
        $this->authorize('update', $user);

        $userRequest->validate([
            'emergency_contact_phone' => ['required',
                new Phone(),
            ],
        ]);

        $message = [];

        $fields = ['emergency_contact_name', 'emergency_contact_relationship', 'emergency_contact_phone', 'message'];

        foreach ($fields as $k => $a) {
            if ($userRequest->$a) {
                $message[ucfirst($a)] = $userRequest->$a;
            }
        }

        if (! empty($message)) {
            $result = $service->sendMessage('Member Emergency Contact Info', $message, $user);
        }

        Session::flash('success', 'Your emergency contact update has been emailed to the office.');

        return redirect()->route('edit_emergency_contact', $user->id);
    }
}
