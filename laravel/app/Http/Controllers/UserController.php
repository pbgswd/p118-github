<?php

namespace App\Http\Controllers;

use App\Http\Requests\Member\UpdateMember;
use App\Http\Requests\Member\UpdateMemberEmergencyContact;
use App\Http\Requests\User\UpdateMemberAddress;
use App\Models\Membership;
use App\Models\PhoneNumber;
use App\Models\User;
use App\Models\UserInfo;
use App\Rules\Phone;
use App\Services\AttachmentService;
use App\Services\EmailMemberUpdateAddressService;
use App\Services\EmailMemberUpdateService;
use http\Client\Request;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

/**
 * Class UserController.
 */
class UserController extends Controller
{
    /**
     * @var EmailMemberUpdateService
     */
    private $emailMemberUpdateService;

    public function __construct(EmailMemberUpdateService $emailMemberUpdateService)
    {
        $this->emailMemberUpdateService = $emailMemberUpdateService;
    }

    /**
     * @return View
     * @throws AuthorizationException
     */
    public function index(): View
    {
        $this->authorize('view', Auth::user());

        $users = User::with(['user_info', 'currentExecutiveRoles', 'membership'])
            ->sortable()
            ->orderBy('name')
            ->paginate(10);

        $count = Membership::where('membership_type', 'Member')->count();

        return view('listusers', ['data' => ['users' => $users, 'count' => $count]]);
    }

    /**
     * @param User $user
     * @return View
     * @throws AuthorizationException
     */
    public function show(User $user): View
    {
        $this->authorize('view', $user);

        $user->load('committee_memberships', 'phone_number',
                    'user_info', 'membership',
                    'allExecutiveRoles');

        $member_roles = $user->getRoleNames()->toArray();
        $member_roles = array_combine($member_roles, $member_roles);

        $data = [
            'user' => $user,
            'user_roles' => $member_roles,
        ];

        return view('member', ['data' => $data]);
    }

    /**
     * @param User $user
     * @return View
     * @throws AuthorizationException
     */
    public function edit(User $user): View
    {
        $this->authorize('update', $user);

        $user->load('phone_number', 'user_info', 'membership', 'committee_memberships', 'allExecutiveRoles');

        $filesize = AttachmentService::human_filesize(\filesize(\storage_path('app/users'.'/'.$user->user_info->image)))
            ? : null;

        $currentUser = Auth::user();
        $roles = Role::get();
        $user_roles = $user->getRoleNames()->toArray();
        $user_roles = array_combine($user_roles, $user_roles);

        $data = [
            'user' => $user,
            'filesize' => $filesize,
            'user_roles' => $user_roles,
            'roles' => $roles,
            'action' => 'Edit',
            'currentUserPermissions' => $currentUser->permissions,
        ];

        return view('member_edit', ['data' => $data]);
    }

    /**
     * @param UpdateMember $userRequest
     * @param User $user
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function update(UpdateMember $userRequest, User $user): RedirectResponse
    {
        $this->authorize('update', $user);

        $user->load('phone_number');

        /** @var array $message */
        $message = [];
        $original_name = $user->name;

        if ($userRequest->user['name'] != $user->name) {
            $message['Name'] = $userRequest->user['name'];
        }

        if ($userRequest->user['email'] != $user->email) {
            $message['Email'] = $userRequest->user['email'];
        }

        $user->fill($userRequest['user']);
        $user->save();
        $user->touch();

        if($userRequest->user_phone['phone_number'] != '') {
            $userRequest->validate([
                'user_phone.phone_number' => [new Phone()]
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

        if ($user->user_info instanceof UserInfo) {
            $user_info = $userRequest['user_info'];

            if (isset($user_info['delete_image'])) {
                Storage::disk('users')->delete($user_info['image']);
                Session::flash('info', 'You have deleted '. $user_info['image']);
                $user_info['image'] = null;
                $user_info['file_name'] = null;
            } else {
                if (! is_null($userRequest->file('image'))) {
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

        if (!empty($message)) {
            $result = $this->emailMemberUpdateService->sendMessage($message, $user, $original_name);
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
            $result = $service->sendMessage('Member Address', $message, $user);
        }

        Session::flash('success', 'Your address update has been emailed to the office.');

        return redirect()->route('member_address_edit', $user->id);
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
            $result = $service->sendMessage('Member Emergency Contact Info', $message, $user);
        }

        Session::flash('success', 'Your emergency contact update has been emailed to the office.');

        return redirect()->route('edit_emergency_contact', $user->id);
    }

    /**
     * @param FormRequest $request
     * @return string
     */
    protected function uploadImage(FormRequest $request): string
    {
        if (null !== $request->file('image')) {
            return $request->file('image')->store('', 'users');
        }
    }
}
