<?php

namespace App\Http\Controllers;

use App\Http\Requests\InviteUser\DestroyInviteUserRequest;
use App\Http\Requests\InviteUser\ProcessUserRequest;
use App\Http\Requests\InviteUser\StoreInviteUserRequest;
use App\Models\InviteUser;
use App\Models\Membership;
use App\Models\Options;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Model;
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
     * @return View
     * @throws AuthorizationException
     */
    public function index(): View
    {
        $this->authorize('viewAny', InviteUser::class);

        $invitations = InviteUser::with('user')
            ->sortable()
            ->paginate(10);
        $invitations->each(function ($item) {
            $item->since = $item->updated_at->diffForHumans(Carbon::now());
            $item->remaining = 48 - $item->updated_at->diffInHours(Carbon::now());
        });

        $data['invitations'] = $invitations;
        $data['count'] = count(InviteUser::all());

        return view('admin.invitations_list', ['data' => $data]);
    }

    /**
     * @return View
     * @throws AuthorizationException
     */
    public function create(): View
    {
        $this->authorize('create', InviteUser::class);

        $invited = new InviteUser;
        $invited->role = ['member' => 'member'];
        $invited->membership_type = 'Member';

        return view('admin.invite_user', ['data' => ['invite' => $invited,
                'roles' => Role::get(),
                'membership' => Options::membership_levels(),
                'action' => 'Invite',
            ],
        ]);
    }

    /**
     * @param StoreInviteUserRequest $request
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function store(StoreInviteUserRequest $request): RedirectResponse
    {
        $this->authorize('create', InviteUser::class);

        $invitation = new InviteUser($request->invite);

        $invitation->password = str_replace('/', '', hash::make(Str::random(8)));

        $invitation->save();

        Mail::send('emails.mail_invited_user', ['data' => ['invitation' => $invitation]],
            function ($m) use ($invitation) {
                $m->from(config('mail.from.address'), config('mail.from.name').' Website Signup');
                $m->to($invitation['email'], $invitation['name'])
                ->replyTo('office@iatse118.com', 'IATSE Local 118 Office')
                ->subject('IATSE Local 118 Website Signup Invitation');
            });

//       return view('emails.mail_invited_user', ['data' => ['invitation' => $invitation]]);

        Session::flash('success', 'Invitation for access sent to '.$invitation['name']);

        return redirect()->route('list_invited_users');
    }

    /**
     * @param InviteUser $inviteUser
     * @return Factory|RedirectResponse|View
     */
    public function show(InviteUser $inviteUser): View
    {
        // method open to whomsoever has the link

        //todo 48 hour signup limitation of 48 hours before need to reapply
        /***
                $now = Carbon::now();
                $allowedInvitationTime = 60 * 48; // 2 days
                $interval = $now->diffInMinutes($inviteUser->updated_at);
                if ($interval > $allowedInvitationTime) {
                    Session::flash('error', "The invitation has expired as it is older than 48 hours.
         * Please contact the site to get a new invitation.");
                    return redirect()->route('hello');
                }
         ***/
        if (null !== User::where('email', $inviteUser->email)->first()) {
            Session::flash('error',
                'The invitation is no longer valid because you have been registered. Login to continue.');

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
     * @return View
     */
    public function list_import(): View
    {
        $data = DB::table('import_users')
            ->whereRaw('email IN (SELECT email FROM invite_users)')
            ->delete();

        $data = DB::table('import_users')
            ->whereRaw('email IN (SELECT email FROM users)')
            ->delete();

        $data = DB::table('import_users')->get();

        return view('admin.invite_list_import', ['data' => $data]);
    }

    /**
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function process_import_invitation(): RedirectResponse
    {
        $this->authorize('create', InviteUser::class);

        $data = DB::table('import_users')
            ->whereRaw('email IN (SELECT email FROM users)')
            ->delete();

        $data = DB::table('import_users')
            ->whereRaw('email NOT IN (SELECT email FROM users)')
            ->whereRaw('email NOT IN (SELECT email FROM invite_users)')
            ->limit(5)
            ->get();

        foreach($data as $user)
        {
            $invitation = new InviteUser();
            $invitation->name = $user->name;
            $invitation->email = $user->email;
            $invitation->password = str_replace('/', '', hash::make(Str::random(8)));
            $invitation->membership_type = $user->membership_type;
            $invitation->role = 'member';
            $invitation->user_id = 1;
            $invitation->message = "";

            $invitation->save();

            Mail::send('emails.mail_invited_user', ['data' => ['invitation' => $invitation]],
                function ($m) use ($invitation) {
                    $m->from(config('mail.from.address'), config('mail.from.name').' Website Signup');
                    $m->to($invitation['email'], $invitation['name'])
                        ->replyTo('office@iatse118.com', 'IATSE Local 118 Office')
                        ->subject('IATSE Local 118 Website Signup Invitation');
                });
        }

        $data = DB::table('import_users')
            ->whereRaw('email IN (SELECT email FROM invite_users)')
            ->delete();

        $data = DB::table('import_users')
            ->whereRaw('email IN (SELECT email FROM users)')
            ->delete();


        Session::flash('success', 'Invitation sent to '.$data->count(). ' members');

        return redirect()->route('list_import');
    }

    /**
     * @param ProcessUserRequest $request
     * @param InviteUser $inviteUser
     * @return RedirectResponse
     */
    public function process_user(ProcessUserRequest $request, InviteUser $inviteUser): RedirectResponse
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

        $membership = new Membership();
        $membership->user_id = $user->id;
        $membership->membership_type = $inviteUser->membership_type;
        $user->membership()->save($membership);

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
        Session::flash('success', 'Thank you! Your password has now been securely stored.
                                    You may now login with your email and password');

        Auth::logout();

        return redirect()->route('login');
    }

    /**
     * @param DestroyInviteUserRequest $request
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function destroy(DestroyInviteUserRequest $request): RedirectResponse
    {
        $this->authorize('delete', InviteUser::class);

        foreach ($request->id as $id) {
            InviteUser::destroy($id);
        }

        Session::flash('success', Str::plural(count($request->id).' Invitation',
            count($request->id).' deleted.'));

        return redirect()->route('list_invited_users');
    }
}
