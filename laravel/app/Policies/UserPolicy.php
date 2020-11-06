<?php

namespace App\Policies;

use App\Models\User;
use Auth;
use Illuminate\Auth\Access\HandlesAuthorization;


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
        return $user->hasRole(['super-admin', 'office',]) ||
            $user->hasPermissionTo('create users');
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
     * @param User $user
     * @param User $userRequest
     * @return bool
     */
    public function view(User $user, User $userRequest)
    {
        return ($userRequest->user_info->show_profile ?? false) === true ||
            $user->id === $userRequest->id;
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
