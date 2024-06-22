<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class InviteUserPolicy
{
    use HandlesAuthorization;

    /**
     * @return bool
     */
    public function before($user)
    {
        $test = $user->hasRole(['super-admin', 'office']) || $user->hasPermissionTo('create users');
        if ($test) {
            return true;
        }
    }

    /**
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole('super-admin') ||
            $user->hasPermissionTo('create users');
    }

    /**
     * @return bool
     */
    public function view(User $user): bool
    {
        return $user->hasRole('super-admin') ||
            $user->hasPermissionTo('create users');
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
    public function update(User $user): bool
    {
        return $user->hasRole(['super-admin', 'office']) ||
            $user->hasPermissionTo('edit users');
    }

    /**
     * @return bool
     */
    public function delete(User $user): bool
    {
        return $user->hasRole(['super-admin', 'office']) ||
            $user->hasPermissionTo('edit users');
    }

    /**
     * @return bool
     */
    public function restore(User $user): bool
    {
        return $user->hasRole(['super-admin', 'office']) ||
            $user->hasPermissionTo('edit users');
    }

    /**
     * @return bool
     */
    public function forceDelete(User $user): bool
    {
        return $user->hasRole(['super-admin', 'office']) ||
            $user->hasPermissionTo('delete users');
    }
}
