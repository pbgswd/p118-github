<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * @return bool
     */
    public function before($user, $ability)
    {
        $test = $user->hasRole(['super-admin', 'office']) || $user->hasPermissionTo('create users');
        if ($test) {
            return true;
        }
    }

    /**
     * Determine whether the user can view any models users.
     *
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['super-admin', 'office']) ||
       $user->hasPermissionTo('create users');
    }

    /**
     * Determine whether the user can view the models user.
     *
     * @return bool
     */
    public function view(User $loggedInUser, User $targetUser): bool
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
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->hasRole(['super-admin', 'office']) ||
            $user->hasPermissionTo('create users');
    }

    /**
     * @return bool
     */
    public function update(User $loggedInUser, User $targetUser): bool
    {
        return $loggedInUser->id === $targetUser->id;
    }

    /**
     * Determine whether the user can update the models user.
     *
     * @return bool
     */
    public function admin_update(User $user)
    {
        return $user->hasRole(['super-admin', 'office']) || $user->hasPermissionTo('edit users');
    }

    /**
     * Determine whether the user can delete the models user.
     *
     * @return bool
     */
    public function delete(User $user): bool
    {
        return $user->hasRole(['super-admin', 'office']) ||
            $user->hasPermissionTo('delete users');
    }

    /**
     * Determine whether the user can restore the models user.
     *
     * @return bool
     */
    public function restore(User $user): bool
    {
        return $user->hasRole('super-admin');
    }

    /**
     * Determine whether the user can permanently delete the models user.
     *
     * @return bool
     */
    public function forceDelete(User $user): bool
    {
        return $user->hasRole('super-admin');
    }
}
