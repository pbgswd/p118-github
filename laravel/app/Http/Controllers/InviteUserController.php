<?php

namespace App\Http\Controllers;

use App\Models\InviteUser;
use App\Models\User;
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
        $data = [];
        $data['invitations'] = InviteUser::with('user')->sortable()->paginate(20);

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
     */
    public function show(InviteUser $inviteUser, $password)
    {
        if($inviteUser->password != $password) {
            Session::flash('error', "The invitation is not valid");
            return redirect()->route('hello');
        }



        //TODO validate, not too old, request validator.

        $regions = $this->getFormOptions(['countries', 'statesprovs']);

        $data = [
            'user' => $inviteUser,
            'invitation' => $inviteUser,
           // 'currentUserPermissions' => $currentUser->permissions,
            'countries' => $regions['countries'],
            'provinces' => $regions['statesprovs']['Provinces'],
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
     * @param User $user
     */
    public function process_user(Request $request, User $user)
    {

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
