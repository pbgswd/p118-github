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
    public function viewAny(User $user)
    {
        return $user->hasRole(['super-admin', 'writer']) ||
            $user->hasAnyPermission(['create articles', 'edit articles', 'publish articles', 'unpublish articles']);
    }

    public function view(User $user, Page $page)
    {
        // no policy, public
    }

    /**
     * @return bool
     *
     * @throws Exception
     */
    public function create(User $user)
    {
        return $user->hasRole(['super-admin', 'writer']) || $user->hasPermission(['create articles']);
    }

    /**
     * @return bool
     */
    public function update(User $user)
    {
        return $user->hasRole(['super-admin', 'writer']) || $user->hasPermission(['update articles']);
    }

    /**
     * @return bool
     */
    public function delete(User $user)
    {
        return $user->hasRole(['super-admin', 'writer']) || $user->hasPermission(['delete articles']);
    }

    /**
     * @return bool
     */
    public function restore(User $user)
    {
        return $user->hasRole(['super-admin', 'writer']) || $user->hasPermission(['delete articles']);
    }

    /**
     * @return bool
     */
    public function forceDelete(User $user)
    {
        return $user->hasRole(['super-admin', 'writer']) || $user->hasPermission(['delete articles']);
    }
}
