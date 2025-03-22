<?php

namespace App\Policies;

use App\Models\Motion;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MotionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
     //   return $user->hasRole(['super-admin', 'writer']) ||
         //   $user->hasAnyPermission(['create articles', 'edit articles', 'publish articles', 'unpublish articles']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Motion $motion): bool
    {
        //todo auth logged in for admin
        return $user->hasRole(['super-admin', 'writer']) || $user->hasPermission(['create articles']);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole(['super-admin', 'writer']) || $user->hasPermission(['create articles']);
        // or Auth::user()
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Motion $motion): Response
    {
        return $user->id === $motion->user_id
            || $user->hasRole(['super-admin', 'writer'])
            || $user->hasPermission(['create articles'])
            ? Response::allow()
            : Response::deny('You do not own this content, you may not edit it.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user): bool
    {
        return $user->hasRole(['super-admin', 'writer']) || $user->hasPermission(['delete articles']);
        // or $motion->user->id == Auth::user()->id
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
