<?php

namespace App\Policies;

use App\Models\Motion;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class MotionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['super-admin', 'writer']) ||
            $user->hasAnyPermission(['create articles', 'edit articles', 'publish articles', 'unpublish articles']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Motion $motion): bool
    {
        //todo auth logged in
        return $user->hasRole(['super-admin', 'writer']) || $user->hasPermission(['create articles']);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole(['super-admin', 'writer']) || $user->hasPermission(['create articles']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user): bool
    {
        return $user->hasRole(['super-admin', 'writer']) || $user->hasPermission(['update articles']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user): bool
    {
        return $user->hasRole(['super-admin', 'writer']) || $user->hasPermission(['delete articles']);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user): bool
    {
        return $user->hasRole(['super-admin', 'writer']) || $user->hasPermission(['create articles']);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user): bool
    {
        return $user->hasRole(['super-admin', 'writer']) || $user->hasPermission(['delete articles']);
    }
}
