<?php

namespace App\Http\Controllers;

use App\Http\Requests\Member\UpdateMember;
use App\Models\Address;
use App\Models\PhoneNumber;
use App\Models\User;
use App\Models\UserInfo;
use App\Services\EmailMemberUpdateService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Storage;

/**
 * Class UserController
 * @package App\Http\Controllers
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
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $users = User::with(['user_info', 'currentExecutiveRoles'])
            ->sortable()
            ->orderBy('name')
            ->paginate(20);
        return view('listusers', ['data' => ['users' => $users]]);
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return Response
     */
    public function show(User $user)
    {
        $this->authorize('view', $user);

        $user->load('committee_memberships', 'phone_number',
                    'user_info', 'address', 'membership',
                    'allExecutiveRoles');

        $roles = Role::get();
        $member_roles = $user->getRoleNames()->toArray();
        $member_roles = array_combine($member_roles, $member_roles);

        $data = [
            'user' => $user,
            'user_roles' => $member_roles,
            'roles' => $roles,
        ];

        return view('member', ['data' => $data]);
    }

    /**
     * @param User $user
     * @return Application|Factory|View
     */

    public function edit(User $user)
    {
        $this->authorize('update', $user);

        $user->load('phone_number', 'user_info', 'address',
            'membership', 'committee_memberships', 'allExecutiveRoles');

        $currentUser = Auth::user();
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
     * @param UpdateMember $userRequest
     * @param User $user
     * @return RedirectResponse
     */
    public function update(UpdateMember $userRequest, User $user)
    {
        $this->authorize('update', $user);

        $user->load('phone_number', 'address');

        $message = [];
        $original_name = $user->name;

        if($userRequest->user['name'] != $user->name) {
            $message['Name'] = $userRequest->user['name'];
        }

        if($userRequest->user['email'] != $user->email) {
            $message['Email'] = $userRequest->user['email'];
        }

        $user->fill($userRequest['user']);
        $user->save();

        if ($user->phone_number instanceof PhoneNumber) {
            $user->phone_number->fill($userRequest['user_phone']);
            $user->phone_number->save();
            if($userRequest->user_phone['phone_number'] != $user->phone_number->phone_number) {
                $message['Phone'] = $userRequest->user_phone['phone_number'];
            }

        } else {
            $phone = new PhoneNumber($userRequest['user_phone']);
            $user->phone_number()->save($phone);
            $message['Phone'] = $userRequest->user_phone['phone_number'];
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

        $addr = ['unit','street','city','province','postal_code','country'];

        foreach($addr as $a)
        {
            if(($userRequest->user_address[$a] ?? '') != ($user->address->$a ?? '')) {
                $message[ucfirst($a)] = $userRequest->user_address[$a];
            }
        }

        if ($user->address instanceof Address) {
            $user->address->fill($userRequest->user_address);
            $user->address->save();
        } else {
            $address = new Address($userRequest->user_address);
            $user->address()->save($address);
        }

        if(!empty($message)) {
            $result = $this->emailMemberUpdateService->sendMessage($message, $user, $original_name);
        }

        Session::flash('success', "You have edited your profile");

        return redirect()->route('member_edit', $user->id);
    }

    protected function uploadImage(FormRequest $request)
    {
        if (null !== $request->file('image')) {
            return $request->file('image')->store('', 'users');
        }
    }
}
