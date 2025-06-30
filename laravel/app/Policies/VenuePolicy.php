<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Venue;
use Illuminate\Auth\Access\HandlesAuthorization;

class VenuePolicy
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

    public function view(User $user, Venue $venue): bool
    {
        // public?
    }

    /**
     * @throws \Exception
     */
    public function create(User $user): bool
    {
        return $user->hasRole(['super-admin', 'writer']) || $user->hasPermission(['create articles']);
    }

    /**
     * @throws \Exception
     */
    public function update(User $user): bool
    {
        return $user->hasRole(['super-admin', 'writer']) || $user->hasPermission(['update articles']);
    }

    /**
     * @throws \Exception
     */
    public function delete(User $user): bool
    {
        return $user->hasRole(['super-admin', 'writer']) || $user->hasPermission(['delete articles']);
    }

    /**
     * @throws \Exception
     */
    public function restore(User $user): bool
    {
        return $user->hasRole(['super-admin', 'writer']) || $user->hasPermission(['create articles']);
    }

    /**
     * @throws \Exception
     */
    public function forceDelete(User $user): bool
    {
        return $user->hasRole(['super-admin', 'writer']) || $user->hasPermission(['delete articles']);
    }
}
