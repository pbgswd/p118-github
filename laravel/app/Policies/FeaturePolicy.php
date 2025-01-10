<?php

namespace App\Policies;

use App\Models\Feature;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FeaturePolicy
{
    use HandlesAuthorization;

    /**
     * @throws \Exception
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['super-admin', 'writer', 'committee']) ||
            $user->hasAnyPermission(['create articles', 'edit articles', 'publish articles', 'unpublish articles']);
    }

    /**
     * Determine whether the user can view the Feature.
     */
    public function view(User $user, Feature $Feature): bool
    {
        //
    }

    /**
     * @throws \Exception
     */
    public function create(User $user): bool
    {
        return $user->hasRole(['super-admin', 'writer', 'committee']) || $user->hasPermission(['create articles']);
    }

    /**
     * @throws \Exception
     */
    public function update(User $user): bool
    {
        return $user->hasRole(['super-admin', 'writer', 'committee']) || $user->hasPermission(['update articles']);
    }

    /**
     * @throws \Exception
     */
    public function delete(User $user): bool
    {
        // admin moderator
        return $user->hasRole(['super-admin', 'writer', 'committee']) || $user->hasPermission(['delete articles']);
    }

    public function restore(User $user): bool
    {
        return $user->hasRole(['super-admin', 'writer', 'committee']) || $user->hasPermission(['create articles']);
    }

    public function forceDelete(User $user): bool
    {
        return $user->hasRole(['super-admin', 'writer', 'committee']) || $user->hasPermission(['delete articles']);
    }
}
