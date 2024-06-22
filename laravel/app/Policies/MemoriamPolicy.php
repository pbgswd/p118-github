<?php

namespace App\Policies;

use App\Models\Memoriam;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MemoriamPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability): bool
    {
        $test = $user->hasRole(['super-admin', 'office']) || $user->hasPermissionTo('create users');
        if ($test) {
            return true;
        }
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['super-admin', 'office']) ||
            $user->hasPermissionTo('create users');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Memoriam $memoriam): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole(['super-admin', 'office']) ||
            $user->hasPermissionTo('create users');
    }

    public function update(User $user, Memoriam $memoriam): bool
    {
        return $user->hasRole(['super-admin', 'office']) ||
            $user->hasPermissionTo('create users');
    }

    public function delete(User $user, Memoriam $memoriam): bool
    {
        return $user->hasRole(['super-admin', 'office']) ||
            $user->hasPermissionTo('create users');
    }

    public function restore(User $user, Memoriam $memoriam): bool
    {
        return $user->hasRole(['super-admin', 'office']) ||
            $user->hasPermissionTo('create users');
    }

    public function forceDelete(User $user, Memoriam $memoriam): bool
    {
        return $user->hasRole(['super-admin', 'office']) ||
            $user->hasPermissionTo('create users');
    }
}
