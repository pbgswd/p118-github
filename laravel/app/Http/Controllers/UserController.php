<?php

namespace App\Http\Controllers;

use App\Http\Requests\InviteUser\ProcessUserRequest;
use App\Http\Requests\Member\UpdateMember;
use App\Http\Requests\Member\UpdateMemberEmergencyContact;
use App\Http\Requests\User\UpdateMemberAddress;
use App\Models\ActivityLog;
use App\Models\Committee;
use App\Models\Executive;
use App\Models\Membership;
use App\Models\MessageSelection;
use App\Models\Options;
use App\Models\PhoneNumber;
use App\Models\Topic;
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

    public function __construct(
        EmailMemberUpdateService $emailMemberUpdateService,
        UserImageService $userImageService)
    {
        $this->emailMemberUpdateService = $emailMemberUpdateService;
        $this->userImageService = $userImageService;
    }

    /**
     * @throws AuthorizationException
     */
    public function index(): View
    {
//todo authorize is having a problem, with a few select users, and my test user
//	$this->authorize('view', Auth::user());

        $users = User::with(['user_info', 'phone_number',
            'currentExecutiveRoles', 'membership', 'committee_memberships'])
            ->sortable()
            ->orderBy('name')
            ->paginate(100, ['*'], __('page'))->onEachSide(0);

        //todo exclude suspended, verify
        $count = Membership::where('membership_type', 'Member')->count();

        return view('listusers', ['data' => ['users' => $users,
            'count' => $count,
            'title' => "Members List"]]);
    }

    /**
     * @throws AuthorizationException
     * @throws InvalidManipulation
     */
    public function show(User $user, UserImageService $service): View
    {
       // $this->authorize('view', $user);

        $user->load('committee_memberships', 'phone_number',
            'user_info', 'membership',
            'allExecutiveRoles', 'message_frequency_preferences');
        //'message_selections');

        $member_roles = $user->getRoleNames()->toArray();
        $member_roles = array_combine($member_roles, $member_roles);

        $folder = $user->getAttachmentFolder();
        $tn_prefix = Options::member_thumb_values()['tn_str'];

/*        if ($user->user_info['image']) {
    if (file_exists(storage_path().'/app/'.$folder.'/'.$user->user_info['image'])) {
        if (! file_exists(storage_path().'/app/'.$folder.'/'.$tn_prefix.$user->user_info['image'])) {
            $service->generate_thumb($user->user_info['image'], $folder,
                Options::member_thumb_values());
        }
    }
    $user->user_info->thumb = $tn_prefix.$user->user_info['image'];
}*/

        if ($user->user_info) {
            if ($user->user_info['image']) {
                if (file_exists(storage_path().'/app/users/' .
                    $user->user_info['image'])) {
                    $filesize = AttachmentService::human_filesize(
                        \filesize(\storage_path('app/users' . '/' .
                            $user->user_info->image))) ?: null;

                    if (! file_exists(storage_path().'/app/users/' .
                        Options::member_thumb_values()['tn_str'] .
                        $user->user_info['image'])) {
                        $this->userImageService
                            ->generate_thumb($user->user_info['image'], 'users',
                            Options::member_thumb_values());
                    }
                }
                $user->user_info->thumb =
                    Options::member_thumb_values()['tn_str'] .
                    $user->user_info['image'];
                $user->user_info->thumb_size =
                    AttachmentService::human_filesize(
                    \filesize(\storage_path('app/users'
                        . '/' . $user->user_info->thumb))) ?: null;
            }
        }

        $regions = $this->getFormOptions(['statesprovs']);

        //todo set default value for email frequency if not exist.

        $topics = Topic::where('live', '=', 1)->get();
        $committees = Committee::where('live', '=', 1)->pluck('name', 'slug')->toArray();

        $selected_topics = MessageSelection::where([['user_id', '=', $user->id], ['type', '=', 'topic']])->pluck('name')->toArray();
        $selected_models = MessageSelection::where([['user_id', '=', $user->id], ['type', '=', 'model']])->pluck('name')->toArray();
        $selected_committees = MessageSelection::where([['user_id', '=', $user->id], ['type', '=', 'committee']])->pluck('name')->toArray();

        $selections = [
            'topics' => array_combine($selected_topics, $selected_topics),
            'models' => array_combine($selected_models, $selected_models),
            'committees' => array_combine($selected_committees, $selected_committees),
        ];

        $data = [
            'user' => $user,
            'user_roles' => $member_roles,
            'committees' => Committee::where('live', '=', 1)->get(),
            'selections' => $selections,
            'message_frequency_preference_options' => Options::message_frequency_preference_options(),
            'topic_subscription_options' => $topics,
            'model_subscription_options' => Options::model_subscription_options(),
            'committee_subscription_options' => Committee::where('live', '=', 1)->get(),
            'folder' => $folder,
            'tn_prefix' => $tn_prefix,
            'filesize' => $filesize ?? '',
            'provinces' => $regions['statesprovs']['Provinces'],
            'action' => 'Edit',
            'title' => $user->name
        ];

        // dd([$selections['topics'], $data['selections']['topics']]);
        return view('member', ['data' => $data]);
    }

    /**
     * @param UpdateMember $userRequest
     * @param UserImageService $service
     * @param User $user
     * @return RedirectResponse
     * @throws InvalidManipulation
     */
    public function update(UpdateMember $userRequest, UserImageService $service,
           User $user): RedirectResponse
    {

//        $this->authorize('update', $user);

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
//todo review phone number validation see app/Rules/Phone.php
        if (isset($userRequest->user_phone['phone_number'])) {
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
            $message['Phone'] = $user_phone_info['phone_number'] == '' ? $user_phone_info['phone_number'] : 'number deleted';
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
            $message['email'] = $user->email;
            $message['name'] = $user->name;
            $result = $this->emailMemberUpdateService->sendMessage($message, $user);
        }

        $al = new ActivityLog([
            'activity' => Auth::user()->name . " updated their personal profile ",
            'ip_address' => $_SERVER['REMOTE_ADDR'],
            'user_agent' => $_SERVER['HTTP_USER_AGENT'],
            'model' => 'Admin']);
        $al->save();

        Session::flash('success', 'Your profile has been edited. The office
            will be updated with any change to your phone number or email address.');

        return redirect()->route('member', $user->id);
    }

    /**
     * @param UpdateMemberAddress $userRequest
     * @param EmailMemberUpdateAddressService $service
     * @param User $user
     * @return RedirectResponse
     */
    public function update_address(
        UpdateMemberAddress $userRequest,
        EmailMemberUpdateAddressService $service,
        User $user): RedirectResponse {
        //$this->authorize('update', $user);
        $message = [];
        $addr = ['unit', 'street', 'city', 'province', 'postal_code', 'message',
            ];

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

        $al = new ActivityLog([
            'activity' => Auth::user()->name . " updated their address ",
            'ip_address' => $_SERVER['REMOTE_ADDR'],
            'user_agent' => $_SERVER['HTTP_USER_AGENT'],
            'model' => 'Admin']);
        $al->save();

        Session::flash('success', 'Your address update has been emailed
            to the office.');

        return redirect()->route('member', $user->id);
    }

    /**
     * @param ProcessUserRequest $request
     * @param User $user
     * @return RedirectResponse
     */
    public function update_password(ProcessUserRequest $request, User $user): RedirectResponse
    {
        //$this->authorize('update', $user);

        $user->fill(['password' => bcrypt($request->password)]);
        $user->save();

        $al = new ActivityLog([
            'activity' => Auth::user()->name . " updated their password ",
            'ip_address' => $_SERVER['REMOTE_ADDR'],
            'user_agent' => $_SERVER['HTTP_USER_AGENT'],
            'model' => 'Admin']);
        $al->save();

        Session::flash('success', 'Your password has been updated.');

        return redirect()->route('member', $user->id);
    }

    /**
     * @param UpdateMemberEmergencyContact $userRequest
     * @param EmailMemberUpdateAddressService $service
     * @param User $user
     * @return RedirectResponse
     */
    public function update_emergency_contact(
        UpdateMemberEmergencyContact $userRequest,
        EmailMemberUpdateAddressService $service,
        User $user): RedirectResponse {

      //  $this->authorize('update', $user);

        $message = [];

        $fields = ['emergency_contact_name',
            'emergency_contact_relationship',
            'emergency_contact_phone',
            'message'];

        foreach ($fields as $k => $a) {
            if ($userRequest->$a) {
                $message[ucfirst($a)] = $userRequest->$a;
            }
        }

        if (! empty($message)) {
            $result = $service->sendMessage('Member Emergency Contact Info',
                $message, $user);
        }

        $al = new ActivityLog([
            'activity' => Auth::user()->name . " updated their emergency contact info",
            'ip_address' => $_SERVER['REMOTE_ADDR'],
            'user_agent' => $_SERVER['HTTP_USER_AGENT'],
            'model' => 'Admin']);
        $al->save();

        Session::flash('success',
            'Your emergency contact update has been emailed to the office.');

        return redirect()->route('member', $user->id);
    }
}
