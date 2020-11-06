<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class InviteUserPolicy
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
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user)
    {
        return $user->hasRole('super-admin')||
            $user->hasPermissionTo('create users');
    }

    /**
     * @param User $user
     * @return bool
     */
    public function view(User $user)
    {
        return $user->hasRole('super-admin')||
            $user->hasPermissionTo('create users');
    }

    /**
     * @param User $user
     * @return bool
     */
    public function create(User $user)
    {
        return $user->hasRole(['super-admin', 'office'])||
            $user->hasPermissionTo('create users');
    }

    /**
     * @param User $user
     * @return bool
     */
    public function update(User $user)
    {
        return $user->hasRole(['super-admin', 'office'])||
            $user->hasPermissionTo('update users');
    }

    /**
     * @param User $user
     * @return bool
     */
    public function delete(User $user)
    {
        return $user->hasRole(['super-admin', 'office'])||
            $user->hasPermissionTo('update users');
    }

    /**
     * @param User $user
     * @return bool
     */
    public function restore(User $user)
    {
        return $user->hasRole(['super-admin', 'office'])||
            $user->hasPermissionTo('update users');
    }

    /**
     * @param User $user
     * @return bool
     */
    public function forceDelete(User $user)
    {
        return $user->hasRole(['super-admin', 'office'])||
            $user->hasPermissionTo('delete users');
    }
}
