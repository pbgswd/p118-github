<?php

namespace App\Http\Controllers;

use App\Http\Requests\InviteUser\ProcessUserRequest;
use App\Models\InviteUser;
use App\Models\User;
use Carbon\Carbon;
use Carbon\Traits\Timestamp;
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

    public function invite()
    {
        //
    }

    public function send()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $invitation = new InviteUser($request->input('invite'));
        $invitation->password = str_replace ('/', '', hash::make(Str::random(8)));
        $invitation->user_id = Auth::user()->id;
        $invitation->role = $request->user_role;
        $invitation->save();
/**
        Mail::send('emails.mail_invited_user', ['data' => $invitation], function ($m) use ($invitation) {
            $m->from('noreply@iatse118.com', 'IATSE 118 Website Signup');
            $m->to($invitation['email'], $invitation['name'])->subject('IATSE Local 118 Website Signup Invitation');
        });
**/
        return view('emails.mail_invited_user', ['data' => ['invitation' => $invitation]]);

      //  Session::flash('success', "Invitation for access sent to " . $invitation['name']);

        //return redirect()->route('show_invited_user', [$invitation->id]);
    }

    /**
     * @param InviteUser $inviteUser
     * @param $password
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function show(InviteUser $inviteUser, $password)
    {
        $inviteUser->diff = $inviteUser->updated_at->diffForHumans(Carbon::now());

        if($inviteUser->password != $password) {
            Session::flash('error', "The invitation is not valid");
            return redirect()->route('hello');
        }

        if ( null !== User::where('email', $inviteUser->email)->first()) {
            Session::flash('error', "The invitation is no longer valid because you have been registered. Login to continue.");
            return redirect()->route('hello');
        }

        //TODO validate, not too old, request validator.

        $data = [
            'user' => $inviteUser,
            'invitation' => $inviteUser,
            'action' => 'Submit',
            ];

        return view('site_invitation', ['data' => $data]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
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
            'password' => bcrypt($request->user['new_password']),
        ];

        $user = new User($data);
        $user->save();

        $user->assignRole($inviteUser->role);

        InviteUser::destroy($inviteUser->id);

        Session::flash('success', "Thank you! Your password has now been securely stored.
                                    You may now login with your email and password");

        return redirect()->route('login');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(InviteUser $inviteUser)
    {
        //$this->authorize('delete', Auth::user());
        // InviteUser::destroy($inviteUser->id);
        // return;
    }
}
