<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ExecutivePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['super-admin', 'office']) ||
            $user->hasAnyPermission(['create users', 'edit users', 'publish users', 'unpublish users']);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole(['super-admin', 'office']) || $user->hasPermissionTo('create users');
    }

    public function update(User $user): bool
    {
        return $user->hasRole(['super-admin', 'office']) || $user->hasPermissionTo('edit users');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user): bool
    {
        return $user->hasRole(['super-admin', 'office']) || $user->hasPermissionTo('delete users');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Executive  $executive
     */
    public function restore(User $user): bool
    {
        return $user->hasRole(['super-admin', 'office']) || $user->hasPermissionTo('create users');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Executive  $executive
     */
    public function forceDelete(User $user): bool
    {
        return $user->hasRole(['super-admin', 'office']) || $user->hasPermissionTo('delete users');
    }
}
