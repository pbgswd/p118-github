<?php

namespace App\Policies;

use App\Models\Bylaw;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BylawPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @return bool
     * @throws \Exception
     */
    public function viewAny(User $user)
    {
        //todo https://laravel.com/docs/6.x/authorization#policy-responses

        if ($user->hasRole('super-admin')) {
            return true;
        }

        if ($user->hasAnyPermission(['create articles', 'edit articles', 'publish articles', 'unpublish articles'])) {
            return true;
        }
    }

    /**
     * Determine whether the user can view the bylaw.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Bylaw  $bylaw
     * @return mixed
     */
    public function view(User $user, Bylaw $bylaw)
    {
        //
    }

    /**
     * @param User $user
     * @return bool
     * @throws \Exception
     */
    public function create(User $user)
    {
        // admin policy
        if ($user->hasAnyRole(['super-admin', 'moderator', 'writer'])) {
            return true;
        }

        if ($user->hasAnyPermission(['create articles', 'edit articles', 'publish articles'])) {
            return true;
        }
    }

    /**
     * @param User $user
     * @param Bylaw $bylaw
     * @return bool
     * @throws \Exception
     */
    public function update(User $user, Bylaw $bylaw)
    {
        // admin policy
        if ($user->hasAnyRole(['super-admin', 'moderator', 'writer'])) {
            return true;
        }

        if ($user->hasAnyPermission(['create articles', 'edit articles', 'publish articles'])) {
            return true;
        }
        return $user->id === $bylaw->user_id;
    }

    /**
     * @param User $user
     * @param Bylaw $bylaw
     * @return bool
     * @throws \Exception
     */
    public function delete(User $user, Bylaw $bylaw)
    {
        // admin policy
        if ($user->hasAnyRole(['super-admin', 'moderator', 'writer'])) {
            return true;
        }

        if ($user->hasAnyPermission(['create articles', 'edit articles', 'publish articles'])) {
            return true;
        }
        return $user->id === $bylaw->user_id;
    }

    /**
     * @param User $user
     * @param Bylaw $bylaw
     * @return bool
     * @throws \Exception
     */
    public function restore(User $user, Bylaw $bylaw)
    {
        // admin policy
        if ($user->hasAnyRole(['super-admin', 'moderator', 'writer'])) {
            return true;
        }

        if ($user->hasAnyPermission(['create articles', 'edit articles', 'publish articles'])) {
            return true;
        }
        return $user->id === $bylaw->user_id;
    }

    /**
     * @param User $user
     * @param Bylaw $bylaw
     * @return bool
     * @throws \Exception
     */
    public function forceDelete(User $user, Bylaw $bylaw)
    {
        // admin policy
        if ($user->hasAnyRole(['super-admin', 'moderator', 'writer'])) {
            return true;
        }

        if ($user->hasAnyPermission(['create articles', 'edit articles', 'publish articles'])) {
            return true;
        }
        return $user->id === $bylaw->user_id;
    }
}
