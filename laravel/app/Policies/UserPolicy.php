<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * @param $user
     * @param $ability
     * @return bool
     */
    public function before($user, $ability): bool
    {
        $test = $user->hasRole(['super-admin', 'office'])
            || $user->hasPermissionTo('create users');

        return $test == true ? true : false;

     /* if ($test) {
            return true;
        }
        else {
            return false;
        }*/
    }

    /**
     * Determine whether the user can view any models users.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['super-admin', 'office']) ||
       $user->hasPermissionTo('create users');
    }

    /**
     * Determine whether the user can view the models user.
     */
    public function view(User $loggedInUser, User $targetUser): bool
    {
        $test = ($loggedInUser->id === $targetUser->id)
            || $loggedInUser->can('edit users') ||
            ($targetUser->user_info->show_profile ?? 0) == 1;

        if ($test) {
            return true;
        }

        $test = ($loggedInUser->id != $targetUser->id)
            && ($loggedInUser->can('edit users') === false) &&
            ($targetUser->user_info->show_profile ?? 0) == 0;

        if ($test) {
            return false;
        }
    }

    /**
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->hasRole(['super-admin', 'office']) ||
            $user->hasPermissionTo('create users');
    }

    /**
     * @param User $loggedInUser
     * @param User $targetUser
     * @return bool
     */
    public function update(User $loggedInUser, User $targetUser): bool
    {
        return $loggedInUser->id === $targetUser->id;
    }

    /**
     * Determine whether the user can update the models user.
     */
    public function admin_update(User $user): bool
    {
        return $user->hasRole(['super-admin', 'office'])
            || $user->hasPermissionTo('edit users');
    }

    /**
     * Determine whether the user can delete the models user.
     */
    public function delete(User $user): bool
    {
        return $user->hasRole(['super-admin', 'office']) ||
            $user->hasPermissionTo('delete users');
    }

    /**
     * Determine whether the user can restore the models user.
     */
    public function restore(User $user): bool
    {
        return $user->hasRole('super-admin');
    }

    /**
     * Determine whether the user can permanently delete the models user.
     */
    public function forceDelete(User $user): bool
    {
        return $user->hasRole('super-admin');
    }
}
