<?php

namespace App\Policies;

use App\Models\InviteUser;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class InviteUserPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @return bool
     * @throws \Exception
     */
    public function viewAny(User $user)
    {
        //todo https://laravel.com/docs/6.x/authorization#policy-responses

        if ($user->hasRole('super-admin')) {
            return true;
        }

        if ($user->hasAnyPermission(['create articles', 'edit articles', 'publish articles', 'unpublish articles'])) {
            return true;
        }
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
     * @param User $user
     * @return bool
     * @throws \Exception
     */
    public function create(User $user)
    {
        // admin policy
        if ($user->hasAnyRole(['super-admin', 'moderator', 'writer'])) {
            return true;
        }

        if ($user->hasAnyPermission(['create articles', 'edit articles', 'publish articles'])) {
            return true;
        }
    }


    /**
     * @param User $user
     * @param InviteUser $inviteUser
     * @return bool
     * @throws \Exception
     */
    public function delete(User $user, InviteUser $inviteUser)
    {
        // admin policy
        if ($user->hasAnyRole(['super-admin', 'moderator', 'writer'])) {
            return true;
        }

        if ($user->hasAnyPermission(['create articles', 'edit articles', 'publish articles'])) {
            return true;
        }
        return $user->id === $inviteUser->user_id;
    }

    /**
     * @param User $user
     * @param InviteUser $inviteUser
     * @return bool
     * @throws \Exception
     */
    public function restore(User $user, InviteUser $inviteUser)
    {
        // admin policy
        if ($user->hasAnyRole(['super-admin', 'moderator', 'writer'])) {
            return true;
        }

        if ($user->hasAnyPermission(['create articles', 'edit articles', 'publish articles'])) {
            return true;
        }
        return $user->id === $inviteUser->user_id;
    }

    /**
     * @param User $user
     * @param InviteUser $inviteUser
     * @return bool
     * @throws \Exception
     */
    public function forceDelete(User $user, InviteUser $inviteUser)
    {
        // admin policy
        if ($user->hasAnyRole(['super-admin', 'moderator', 'writer'])) {
            return true;
        }

        if ($user->hasAnyPermission(['create articles', 'edit articles', 'publish articles'])) {
            return true;
        }
        return $user->id === $inviteUser->user_id;
    }
}
