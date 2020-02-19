<?php

namespace App\Policies;

use App\Models\User;
use Auth;
use Illuminate\Auth\Access\HandlesAuthorization;


class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models users.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        if ($user->hasRole('super-admin')) {
            return true;
        }

        if ($user->can('create users')) {
            return true;
        }
    }

    /**
     * Determine whether the user can view the models user.
     *
     * @param  \App\Models\User  $user
     * @param  \User  $user
     * @return mixed
     */
    public function view(User $user, User $userRequest)
    {
        if ($user->hasRole('super-admin')) {
            return true;
        }
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
     *
     * @param  \App\Models\User  $user
     * @param  \User  $user
     * @return mixed
     */
    public function update(User $currentUser, User $targetUser)
    {
        if ($currentUser->hasRole('super-admin')) {
            return true;
        }

        if ($currentUser->can('edit users')) {
            return true;
        }

        return $currentUser->id === $targetUser->id;
    }

    /**
     * Determine whether the user can update the models user.
     *
     * @param  \App\Models\User  $user
     * @param  \User  $user
     * @return mixed
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
     *
     * @param  \App\Models\User  $user
     * @param  \User  $user
     * @return mixed
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
     *
     * @param  \App\Models\User  $user
     * @param  \User  $user
     * @return mixed
     */
    public function restore(User $user)
    {
        if ($user->hasRole('super-admin')) {
            return true;
        }
    }

    /**
     * Determine whether the user can permanently delete the models user.
     *
     * @param  \App\Models\User  $user
     * @param  \User  $user
     * @return mixed
     */
    public function forceDelete(User $user)
    {
        if ($user->hasRole('super-admin')) {
            return true;
        }
    }
}
