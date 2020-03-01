<?php

namespace App\Policies;

use App\Models\InviteUser;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class InviteUserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any invite users.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the invite user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\InviteUser  $inviteUser
     * @return mixed
     */
    public function view(User $user, InviteUser $inviteUser)
    {
        //
    }

    /**
     * Determine whether the user can create invite users.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the invite user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\InviteUser  $inviteUser
     * @return mixed
     */
    public function update(User $user, InviteUser $inviteUser)
    {
        //
    }

    /**
     * Determine whether the user can delete the invite user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\InviteUser  $inviteUser
     * @return mixed
     */
    public function delete(User $user, InviteUser $inviteUser)
    {
        //
    }

    /**
     * Determine whether the user can restore the invite user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\InviteUser  $inviteUser
     * @return mixed
     */
    public function restore(User $user, InviteUser $inviteUser)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the invite user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\InviteUser  $inviteUser
     * @return mixed
     */
    public function forceDelete(User $user, InviteUser $inviteUser)
    {
        //
    }
}
