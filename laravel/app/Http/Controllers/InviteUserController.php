<?php

namespace App\Http\Controllers;

use App\Http\Requests\InviteUser\DestroyInviteUserRequest;
use App\Http\Requests\InviteUser\ProcessUserRequest;
use App\Http\Requests\InviteUser\StoreInviteUserRequest;
use App\Models\InviteUser;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class InviteUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invitations = InviteUser::with('user')->sortable()->paginate(20);
        $invitations->each(function ($item, $key) {
            $item->since = $item->updated_at->diffForHumans(Carbon::now());
        });

        $data['invitations'] = $invitations;
        $data['count'] = count(InviteUser::all());

        return view('admin.invitations_list', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //invite new user
        //todo create invite user policy
        $invited = new InviteUser;
        $invited->role = ['member' => 'member'];

        return view('admin.invite_user', ['data' => ['invite' => $invited, 'roles' => Role::get(), 'action' => 'Invite']]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreInviteUserRequest  $request)
    {
        $invitation = new InviteUser($request->input('invite'));
        $invitation->password = str_replace ('/', '', hash::make(Str::random(8)));
        $invitation->user_id = Auth::user()->id;
        $invitation->role = $request->user_role;
        $invitation->save();

        Mail::send('emails.mail_invited_user', ['data' => ['invitation' => $invitation]], function ($m) use ($invitation) {
            $m->from('noreply@iatse118.com', 'IATSE 118 Website Signup');
            $m->to($invitation['email'], $invitation['name'])->subject('IATSE Local 118 Website Signup Invitation');
        });

       // return view('emails.mail_invited_user', ['data' => ['invitation' => $invitation]]);

      Session::flash('success', "Invitation for access sent to " . $invitation['name']);

        return redirect()->route('list_invited_users');
    }

    /**
     * @param InviteUser $inviteUser
     * @param $password
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function show(InviteUser $inviteUser, $password)
    {
        if($inviteUser->password != $password) {
            Session::flash('error', "The invitation is not valid");
            return redirect()->route('hello');
        }

        $now = Carbon::now();
        $allowedInvitationTime = 60 * 48; // 2 days
        $interval = $now->diffInMinutes($inviteUser->updated_at);
        if ($interval > $allowedInvitationTime) {
            Session::flash('error', "The invitation has expired as it is older than 48 hours. Please contact the site to get a new invitation.");
            return redirect()->route('hello');
        }

        if ( null !== User::where('email', $inviteUser->email)->first()) {
            Session::flash('error', "The invitation is no longer valid because you have been registered. Login to continue.");
            return redirect()->route('hello');
        }

        $data = [
            'user' => $inviteUser,
            'invitation' => $inviteUser,
            'action' => 'Submit',
            ];

        return view('site_invitation', ['data' => $data]);
    }

    /**
     * @param Request $request
     * @param InviteUser $inviteUser
     * @return \Illuminate\Http\RedirectResponse
     */
    public function process_user(ProcessUserRequest $request, InviteUser $inviteUser)
    {
        $data = [
            'name' => $inviteUser->name,
            'email' => $inviteUser->email,
            'email_verified_at' => Carbon::now()->toDateTimeString(),
            'password' => bcrypt($request->password),
        ];

        $user = new User($data);
        $user->save();

        $user->assignRole($inviteUser->role);

        InviteUser::destroy($inviteUser->id);

        InviteUser::where('email', $inviteUser->email)->delete();

        //todo helper method to clean out old invitations.
        /**
            $cleanOldInvitations = InviteUser::all();
            foreach ($cleanOldInvitations as $c)
            {
                if($c->email == User::select('email')->where('email',$c->email)->get()) {
                    InviteUser::destroy($c->id);
                }
            }

            $cleanOldInvitations->each(function ($item, $key) {
            //InviteUser::where('email', User::select('email')->where('email',$item->email)->get())->delete();
            if($item->email == User::select('email')->where('email',$item->email)->get()) {
            InviteUser::destroy($item->id);
            }
            });
         */

        Session::flash('success', "Thank you! Your password has now been securely stored.
                                    You may now login with your email and password");

        return redirect()->route('login');
    }

    /**
     * @param DestroyInviteUserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(DestroyInviteUserRequest $request)
    {
        $this->authorize('delete', Auth::user());
        foreach ($request->id as $id)
        {
            InviteUser::destroy($id);
        }

        Session::flash('success',  Str::plural(count($request->id) . ' Invitation', count($request->id) . ' deleted.'));
        return redirect()->route('list_invited_users');
    }
}
