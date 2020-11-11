<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\DestroyUser;
use App\Http\Requests\User\StoreUser;
use App\Http\Requests\User\UpdateUser;
use App\Models\Address;
use App\Models\Executive;
use App\Models\ExecutiveMembership;
use App\Models\Membership;
use App\Models\Options;
use App\Models\PhoneNumber;
use App\Models\User;
use App\Models\UserInfo;
use App\Services\EmailMemberUpdateService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
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
     * @var EmailMemberUpdateService
     */

    private $emailMemberUpdateService;

    public function __construct(EmailMemberUpdateService $emailMemberUpdateService)
    {
        $this->emailMemberUpdateService = $emailMemberUpdateService;
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
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

        return view('admin.listusers', ['data' => ['users' => $users]]);
    }

    /**
     * @return Factory|View
     */
    public function create()
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
     */
    public function store(StoreUser $request)
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
     * @return Factory|View
     */

    public function edit(User $user)
    {
        $this->authorize('admin_update', Auth::user());

        $user->load('phone_number',
                    'user_info',
                    'address',
                    'allExecutiveRoles',
                    'committee_memberships',
                    'membership'
                    );

        $regions = $this->getFormOptions(['countries', 'statesprovs']);

        $user_roles = $user->getRoleNames()->toArray();
        $user_roles = array_combine($user_roles, $user_roles);

        $data = [
            'user' => $user,
            'membership' => Options::membership_levels(),
            'executive_roles' => Executive::all(),
            'user_roles' => $user_roles,
            'roles' => Role::get(),
            'countries' => $regions['countries'],
            'provinces' => $regions['statesprovs']['Provinces'],
            'action' => 'Edit',
        ];

        return view('admin.user', ['data' => $data]);
    }

    /**
     * @param UpdateUser $request
     * @param User $user
     * @return RedirectResponse
     */
    public function update(UpdateUser $request, User $user)
    {
        $this->authorize('admin_update', Auth::user());

        $user->load('phone_number', 'address');

        $message = [];
        $original_name = $user->name;

        if($request->user['name'] != $user->name) {
            $message['Name'] = $request->user['name'];
        }

        if($request->user['email'] != $user->email) {
            $message['Email'] = $request->user['email'];
        }

        $user->fill($request['user']);
        $user->save();

        if ($user->phone_number instanceof PhoneNumber) {
            $user->phone_number->fill($request['user_phone']);
            $user->phone_number->save();
            if($request->user_phone['phone_number'] != $user->phone_number->phone_number ) {
                $message['Phone'] = $request->user_phone['phone_number'];
            }
        } else {
            $phone = new PhoneNumber($request['user_phone']);
            $user->phone_number()->save($phone);
            $message['Phone'] = $request->user_phone['phone_number'];
        }

        if ($user->user_info instanceof UserInfo) {
            $user_info = $request['user_info'];

            if (isset($user_info['delete_image'])) {
                Storage::disk('users')->delete($user_info['image']);

                Session::flash('info', "You have deleted " . $user_info['image']);
                $user_info['image'] = null;
                $user_info['file_name'] = null;
            } else {
                if (!is_null($request->file('image'))) {
                    $user_info['image'] = $this->uploadImage($request);
                    $user_info['file_name'] = $request->image->getClientOriginalName();
                }
            }
            $user->user_info->fill($user_info);
            $user->user_info->save();
        } else {
            $user_info = new UserInfo($request->input('user_info'));

            if(null !== $request->file) {
                $user_info->image = $this->uploadImage($request);
            }
            $user->user_info()->save($user_info);
        }

        $addr = ['unit','street','city','province','postal_code','country'];

        if ($user->address instanceof Address) {

            foreach($addr as $a)
            {
                if($request->user_address[$a] != $user->address->$a) {
                    $message[ucfirst($a)] = $request->user_address[$a];
                }
            }

            $user->address->fill($request['user_address']);
            $user->address->save();

        } else {
            $address = new Address($request['user_address']);

            foreach($addr as $a)
            {
               $message[ucfirst($a)] = $request->user_address[$a];
            }

            $user->address()->save($address);
        }

        $user->syncRoles($request['user_role']);

        if ($user->membership instanceof Membership) {
            $user->membership->fill($request['user_membership']);
            $user->membership->save();
        } else {
            $membership = new Membership($request['user_membership']);
            $user->membership()->save($membership);
        }

        if(!empty($message)) {
            $result = $this->emailMemberUpdateService->sendMessage($message, $user, $original_name);
        }

        Session::flash('success', "You have edited a member profile");

        return redirect()->route('user_edit', [$user->id]);
    }

    /**
     * @param DestroyUser $request
     * @return RedirectResponse

     */
    public function destroy(DestroyUser $request)
    {
        $this->authorize('delete', Auth::user());

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

            PhoneNumber::where('user_id', $user->id)->delete();
            Address::where('user_id', $user->id)->delete();
            Membership::where('user_id', $user->id)->delete();

            $user_info = UserInfo::where('user_id', $user->id)->first();
            if ($user_info['image']) {
                Storage::disk('users')->delete($user_info['image']);
            }

            UserInfo::destroy($user_info['id']);

            $e = ExecutiveMembership::find($user->id);
            if(null != $e) {
                $e->delete();
            }

            $user->allExecutiveRoles()->detach();

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
