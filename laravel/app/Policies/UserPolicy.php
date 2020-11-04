<?php

namespace App\Policies;

use App\Models\User;
use Auth;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Session;


class UserPolicy
{
    use HandlesAuthorization;

    /**
     * @param $user
     * @param $ability
     * @return bool
*/
    public function before($user, $ability)
    {
        if ($user->can('edit users')) {
            return true;
        }
        if ($user->hasRole(['super-admin', 'office'])) {
            return true;
        }
    }

    /**
     * Determine whether the user can view any models users.
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user)
    {
        if ($user->can('create users')) {
            return true;
        }
    }

    /**
     * Determine whether the user can view the models user.
     * @param User $user
     * @param User $userRequest
     * @return bool
     */
    public function view(User $user, User $userRequest)
    {
        return ($userRequest->user_info->show_profile ?? false) === true;

        return $user->id === $userRequest->id;
    }

    /**
     * Determine whether the user can create models users.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        if ($user->hasRole('super-admin')) {
            return true;
        }

        if ($user->can('create users')) {
            return true;
        }
    }

    /**
     * Determine whether the user can update the models user.
     * @param User $currentUser
     * @param User $targetUser
     * @return bool
     */
    public function update(User $currentUser, User $targetUser)
    {
        return $currentUser->id === $targetUser->id;
    }

    /**
     * Determine whether the user can update the models user.
     * @param User $user
     * @return bool
     */
    public function admin_update(User $user)
    {
        if ($user->hasRole('super-admin')) {
            return true;
        }

        if ($user->can('edit users')) {
            return true;
        }
    }

    /**
     * Determine whether the user can delete the models user.
     * @param User $user
     * @return bool
     */
    public function delete(User $user)
    {
        if ($user->hasRole('super-admin')) {
            return true;
        }

        if ($user->can('delete users')) {
            return true;
        }
    }





    /**
     * Determine whether the user can restore the models user.
     * @param User $user
     * @return bool
     */
    public function restore(User $user)
    {
        if ($user->hasRole('super-admin')) {
            return true;
        }
    }

    /**
     * Determine whether the user can permanently delete the models user.
     * @param User $user
     * @return bool
     */
    public function forceDelete(User $user)
    {
        if ($user->hasRole('super-admin')) {
            return true;
        }
    }
}
