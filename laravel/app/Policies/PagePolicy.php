<?php

namespace App\Policies;

use App\Models\Page;
use App\Models\User;
use Exception;
use Illuminate\Auth\Access\HandlesAuthorization;

class PagePolicy
{
    use HandlesAuthorization;

    /**
     * @return bool|void
     *
     * @throws Exception
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['super-admin', 'writer']) ||
            $user->hasAnyPermission(['create articles', 'edit articles', 'publish articles', 'unpublish articles']);
    }

    public function view(User $user, Page $page): bool
    {
        // no policy, public
    }

    /**
     * @throws Exception
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
        return $user->hasRole(['super-admin', 'writer']) || $user->hasPermission(['delete articles']);
    }

    public function forceDelete(User $user): bool
    {
        return $user->hasRole(['super-admin', 'writer']) || $user->hasPermission(['delete articles']);
    }

}
