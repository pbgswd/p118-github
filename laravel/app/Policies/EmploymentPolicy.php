<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EmploymentPolicy
{
    use HandlesAuthorization;

    /**
     * @throws \Exception
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['super-admin', 'writer']) ||
            $user->hasAnyPermission(['create articles', 'edit articles', 'publish articles', 'unpublish articles']);
    }

    /**
     * Determine whether the user can view the employment.
     */
    public function view(User $user): bool
    {
        //
    }

    /**
     * @throws \Exception
     */
    public function create(User $user): bool
    {
        return $user->hasRole(['super-admin', 'writer']) || $user->hasPermission(['create articles']);
    }

    public function update(User $user): bool
    {
        return $user->hasRole(['super-admin', 'writer']) || $user->hasPermission(['update articles']);
    }

    public function delete(User $user): bool
    {
        return $user->hasRole(['super-admin', 'writer']) || $user->hasPermission(['delete articles']);
    }

    public function restore(User $user): bool
    {
        return $user->hasRole(['super-admin', 'writer']) || $user->hasPermission(['create articles']);
    }

    public function forceDelete(User $user): bool
    {
        return $user->hasRole(['super-admin', 'writer']) || $user->hasPermission(['delete articles']);
    }
}
