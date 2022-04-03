<?php

namespace App\Http\Controllers;

use App\Models\InviteUser;
use App\Models\Membership;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class ReInviteUserController extends Controller
{
    /**
     * @return RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(): RedirectResponse
    {
        $this->authorize('viewAny', InviteUser::class);

        DB::table('invite_users')
            ->whereRaw('email IN (SELECT email FROM users)')
            ->delete();

        $data = [];
        $data['invitations'] = InviteUser::all();

        foreach ($data['invitations'] as $i) {
            $password = str_replace('/', '', hash::make(Str::random(8)));
            $user = new User(array_merge(['name' => $i->name, 'email' => $i->email], ['password' => bcrypt($password)]));
            $user->save();
            $user->assignRole('member');
            $membership = new Membership();
            $membership->user_id = $user->id;
            $membership->membership_type = 'Member';
            $user->membership()->save($membership);
        }

        $data['count'] = count(InviteUser::all());

        Session::flash('success', $data['count'].' pending members have been reinvited by adding them as members');

        Log::debug(' On '.date('Y-m-d H:i:s').', '.$data['count'].' pending members were
            reinvited, by adding them as members');

        return redirect()->route('admin_list_invited_users');
    }
}
