<?php

namespace App\Policies;

use App\Models\User;
use Auth;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Request;


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
        $test = $user->hasRole(['super-admin', 'office',]) || $user->hasPermissionTo('create users');
        if ($test) {
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
       return $user->hasRole(['super-admin', 'office']) ||
       $user->hasPermissionTo('create users');
    }

    /**
     * Determine whether the user can view the models user.
     * @param User $loggedInUser
     * @param User $targetUser
     * @return bool
     */
    public function view(User $loggedInUser, User $targetUser)
    {
        $test = ($loggedInUser->id === $targetUser->id) || $loggedInUser->can('edit users') ||
            ($targetUser->user_info->show_profile ?? 0) == 1;

        if ($test) {
            return true;
        }

        $test = ($loggedInUser->id != $targetUser->id) && ($loggedInUser->can('edit users') === false) &&
            ($targetUser->user_info->show_profile ?? 0) == 0;

        if ($test) {
            return false;
        }

    }

    /**
     * @param User $user
     * @return bool
     */
    public function create(User $user)
    {
        return $user->hasRole(['super-admin', 'office']) ||
            $user->hasPermissionTo('create users');
    }

    /**
     * @param User $user
     * @return bool
     */
    public function update(User $user)
    {
        //public side
        //owner of user profile can edit
        $loggedIn = Auth::user();
        return $user->id === $loggedIn->id;

    }

    /**
     * Determine whether the user can update the models user.
     * @param User $user
     * @return bool
     */
    public function admin_update(User $user)
    {
        return $user->hasRole(['super-admin', 'office']);
    }

    /**
     * Determine whether the user can delete the models user.
     * @param User $user
     * @return bool
     */
    public function delete(User $user)
    {
        return $user->hasRole(['super-admin', 'office']) ||
            $user->hasPermissionTo('delete users');
    }


    /**
     * Determine whether the user can restore the models user.
     * @param User $user
     * @return bool
     */
    public function restore(User $user)
    {
        return $user->hasRole('super-admin');
    }

    /**
     * Determine whether the user can permanently delete the models user.
     * @param User $user
     * @return bool
     */
    public function forceDelete(User $user)
    {
        return $user->hasRole('super-admin');
    }
}
