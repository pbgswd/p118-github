<?php

namespace App\Http\Controllers;

use App\Http\Requests\Member\UpdateMember;
use App\Http\Requests\User\UpdateMemberAddress;
use App\Models\Membership;
use App\Models\PhoneNumber;
use App\Models\User;
use App\Models\UserInfo;
use App\Services\EmailMemberUpdateAddressService;
use App\Services\EmailMemberUpdateService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
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
    private $emailMemberUpdateAddressService;

    public function __construct(EmailMemberUpdateService $emailMemberUpdateService)
    {
        $this->emailMemberUpdateService = $emailMemberUpdateService;
    }

    /**
     * @return Application|Factory|View
     * @throws AuthorizationException
     */
    public function index()
    {
        $this->authorize('viewAny', Auth::user());

        $users = User::with(['user_info', 'currentExecutiveRoles', 'membership'])
            ->sortable()
            ->orderBy('name')
            ->paginate(20);

        //dd($users[0]);

        $count = Membership::where('membership_type', 'Member')->count();

        return view('listusers', ['data' => ['users' => $users, 'count' => $count]]);
    }

    /**
     * @param User $user
     * @return Application|Factory|View
     * @throws AuthorizationException
     */
    public function show(User $user)
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
     * @return Application|Factory|View
     * @throws AuthorizationException
     */
    public function edit(User $user)
    {
        $this->authorize('update', $user);

        $user->load('phone_number', 'user_info', 'membership', 'committee_memberships', 'allExecutiveRoles');

        $currentUser = Auth::user();
        $roles = Role::get();
        $user_roles = $user->getRoleNames()->toArray();
        $user_roles = array_combine($user_roles, $user_roles);

        $data = [
            'user' => $user,
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

        if ($user->phone_number instanceof PhoneNumber) {
            if ($userRequest->user_phone['phone_number'] != $user->phone_number['phone_number']) {
                $message['Phone'] = $userRequest->user_phone['phone_number'];
            }
            $user->phone_number->fill($userRequest->user_phone);
            $user->phone_number->save();
        } else {
            $phone = new PhoneNumber($userRequest['user_phone']);
            $user->phone_number()->save($phone);
            $message['Phone'] = $userRequest->user_phone['phone_number'];
        }

        if ($user->user_info instanceof UserInfo) {
            $user_info = $userRequest['user_info'];

            if (isset($user_info['delete_image'])) {
                Storage::disk('users')->delete($user_info['image']);
                Session::flash('info', 'You have deleted '.$user_info['image']);
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

        if (! empty($message)) {
            $result = $this->emailMemberUpdateService->sendMessage($message, $user, $original_name);
        }

        //todo ONLY trigger update email when change in name or email or phone

        Session::flash('success', 'Profile for '.$user->name.' has been edited. The office will be updated.');

        return redirect()->route('member_edit', $user->id);
    }

    public function edit_address(User $user)
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
     * @param User $user
     * @param EmailMemberUpdateAddressService $service
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
            $result = $service->sendMessage($message, $user);
        }

        Session::flash('success', 'Address update for '.$user->name.' has been emailed to the office.');

        return redirect()->route('member_edit', $user->id);
    }

    protected function uploadImage(FormRequest $request)
    {
        if (null !== $request->file('image')) {
            return $request->file('image')->store('', 'users');
        }
    }
}
