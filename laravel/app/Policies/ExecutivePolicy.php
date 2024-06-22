<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ExecutivePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @return mixed
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['super-admin', 'office']) ||
            $user->hasAnyPermission(['create users', 'edit users', 'publish users', 'unpublish users']);
    }

    /**
     * Determine whether the user can create models.
     *
     * @return mixed
     */
    public function create(User $user): bool
    {
        return $user->hasRole(['super-admin', 'office']) || $user->hasPermissionTo('create users');
    }

    /**
     * @return bool
     */
    public function update(User $user): bool
    {
        return $user->hasRole(['super-admin', 'office']) || $user->hasPermissionTo('edit users');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @return mixed
     */
    public function delete(User $user): bool
    {
        return $user->hasRole(['super-admin', 'office']) || $user->hasPermissionTo('delete users');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Executive  $executive
     * @return mixed
     */
    public function restore(User $user): bool
    {
        return $user->hasRole(['super-admin', 'office']) || $user->hasPermissionTo('create users');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Executive  $executive
     * @return mixed
     */
    public function forceDelete(User $user): bool
    {
        return $user->hasRole(['super-admin', 'office']) || $user->hasPermissionTo('delete users');
    }
}
