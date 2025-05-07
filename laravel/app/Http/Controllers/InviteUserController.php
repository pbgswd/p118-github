<?php

namespace App\Http\Controllers;

use App\Http\Requests\InviteUser\DestroyInviteUserRequest;
use App\Http\Requests\InviteUser\ProcessUserRequest;
use App\Http\Requests\InviteUser\StoreInviteUserRequest;
use App\Models\ActivityLog;
use App\Models\InviteUser;
use App\Models\Membership;
use App\Models\MessageSelection;
use App\Models\Options;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class InviteUserController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function index(): View
    {
        $this->authorize('viewAny', InviteUser::class);

        DB::table('invite_users')
            ->whereRaw('email IN (SELECT email FROM users)')
            ->delete();

        $invitations = InviteUser::with('user')
            ->sortable()
            ->paginate(10);

        $invitations->each(function ($item) {
            $item->since = $item->updated_at->diffForHumans(Carbon::now());
            $item->remaining = 48 -
                $item->updated_at->diffInHours(Carbon::now());
        });

        $data = [];
        $data['invitations'] = $invitations;
        $data['all'] = InviteUser::all();
        $data['count'] = count(InviteUser::all());

        return view('admin.users.invitations_list', ['data' => $data]);
    }

    /**
     * @throws AuthorizationException
     */
    public function create(): View
    {
        $this->authorize('create', InviteUser::class);

        $invited = new InviteUser;
        $invited->role = ['member' => 'member'];
        $invited->membership_type = 'Member';

        return view('admin.users.invite_user', ['data' => ['invite' => $invited,
            'roles' => Role::get(),
            'membership' => Options::membership_levels(),
            'action' => 'Invite',
            ],
        ]);
    }

    /**
     * @throws AuthorizationException
     */
    public function store(StoreInviteUserRequest $request): RedirectResponse
    {
        $this->authorize('create', InviteUser::class);

        $invite = $request['invite'];
        $invite['password'] = str_replace('/', '', hash::make(Str::random(8)));

        $invitation = new InviteUser($invite);
        $invitation->save();

        Mail::send('emails.mail_invited_user', ['data' =>
            ['invitation' => $invitation]],
            function ($m) use ($invitation) {
                $m->from(config('mail.from.address'),
                    config('mail.from.name').' Website Signup');
                $m->to($invitation['email'], $invitation['name'])
                    ->replyTo('office@iatse118.com', 'IATSE Local 118 Office')
                    ->subject('IATSE Local 118 Website Signup Invitation');
            });

        $al = new ActivityLog([
            'activity' => 'A website invitation has been sent to ' .
                $invitation['name'] . '.',
            'ip_address' => $_SERVER['REMOTE_ADDR'],
            'user_agent' => $_SERVER['HTTP_USER_AGENT'],
            'model' => 'InviteUser']);
        $al->save();

        Session::flash('success', 'Invitation for access sent to ' .
            $invitation['name']);

        return redirect()->route('admin_list_invited_users');
    }

    /**
     * @return Factory|RedirectResponse|View
     */
    public function show(InviteUser $inviteUser): View
    {
//todo 48 hour signup limitation of 48 hours before need to reapply
/***
    $now = Carbon::now();
    $allowedInvitationTime = 60 * 48; // 2 days
    $interval = $now->diffInMinutes($inviteUser->updated_at);
    if ($interval > $allowedInvitationTime) {
        Session::flash('error',
 * "The invitation has expired as it is older than 48 hours.
* Please contact the site to get a new invitation.");
        return redirect()->route('hello');
    }
***/
        if (User::where('email', $inviteUser->email)->first() !== null) {
            Session::flash('error',
                'The invitation is no longer valid because you have been
                registered. Login to continue.');

            return redirect()->route('login');
        }

        $data = [
            'user' => $inviteUser,
            'invitation' => $inviteUser,
            'action' => 'Submit',
        ];

        return view('site_invitation', ['data' => $data]);
    }

    public function list_import(): View
    {
        DB::table('import_users')
            ->whereRaw('email IN (SELECT email FROM invite_users)')
            ->delete();

        DB::table('import_users')
            ->whereRaw('email IN (SELECT email FROM users)')
            ->delete();

        DB::table('invite_users')
            ->whereRaw('email IN (SELECT email FROM users)')
            ->delete();

        $data = DB::table('import_users')->get();

        return view('admin.users.invite_list_import', ['data' => $data]);
    }

    /**
     * @throws AuthorizationException
     */
    public function process_import_invitation(): RedirectResponse
    {
        $this->authorize('create', InviteUser::class);

        DB::table('import_users')
            ->whereRaw('email IN (SELECT email FROM invite_users)')
            ->delete();

        DB::table('import_users')
            ->whereRaw('email IN (SELECT email FROM users)')
            ->delete();

        DB::table('invite_users')
            ->whereRaw('email IN (SELECT email FROM users)')
            ->delete();

        $data = [];

        $data = DB::table('import_users')
            ->whereRaw('email NOT IN (SELECT email FROM users)')
            ->whereRaw('email NOT IN (SELECT email FROM invite_users)')
            ->limit(25)
            ->get();

        $count = count($data);

        foreach ($data as $user) {
            $invitation = new InviteUser;
            $invitation->name = $user->name;
            $invitation->email = $user->email;
            $invitation->password = str_replace('/', '',
                hash::make(Str::random(8)));
            $invitation->membership_type = $user->membership_type;
            $invitation->role = 'member';
            $invitation->user_id = 1;
            $invitation->message = '';

            $invitation->save();

            Mail::send('emails.mail_invited_user', ['data' =>
                ['invitation' => $invitation]],
                function ($m) use ($invitation) {
                    $m->from(config('mail.from.address'),
                        config('mail.from.name').' Website Signup');
                    $m->to($invitation['email'], $invitation['name'])
                        ->replyTo('office@iatse118.com',
                            'IATSE Local 118 Office')
                        ->subject('IATSE Local 118 Website Signup Invitation');
                });
        }

        DB::table('import_users')
            ->whereRaw('email IN (SELECT email FROM invite_users)')
            ->delete();

        DB::table('import_users')
            ->whereRaw('email IN (SELECT email FROM users)')
            ->delete();

        Session::flash('success', 'Invitation sent to '.$count.' members');

        return redirect()->route('list_import');
    }

    public function process_user(ProcessUserRequest $request,
                                 InviteUser $inviteUser): RedirectResponse
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

        $membership = new Membership;
        $membership->user_id = $user->id;
        $membership->membership_type = $inviteUser->membership_type;
        $user->membership()->save($membership);

        $ms = new MessageSelection;
        $ms->user_id = $user->id;
        $ms->type = 'model';
        $ms->name = 'Message';
        $ms->save();

        InviteUser::where('email', $inviteUser->email)->delete();

        $al = new ActivityLog([
            'activity' => $user->name .
                ' has completed website signup',
                'ip_address' => $_SERVER['REMOTE_ADDR'],
                'user_agent' => $_SERVER['HTTP_USER_AGENT'],
                'model' => 'InviteUser']);

        $al->save();

        Session::flash('success', 'Thank you! Your password has now been
            securely stored. You may now login with your email and password');

        Auth::logout();

        return redirect()->route('login');
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy(DestroyInviteUserRequest $request): RedirectResponse
    {
        $this->authorize('delete', InviteUser::class);

        InviteUser::find($request->id)
            ->each(function (InviteUser $inviteUser) {
                $inviteUser->delete();
            });

        Session::flash('success', Str::plural(count([$request->id]) .
            ' Invitation'.' deleted.'));

        return redirect()->route('users.admin_list_invited_users');
    }
}
