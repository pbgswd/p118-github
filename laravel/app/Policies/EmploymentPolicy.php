<?php

namespace App\Policies;

use App\Models\Employment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EmploymentPolicy
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
     * Determine whether the user can view the employment.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Employment  $employment
     * @return mixed
     */
    public function view(User $user, Employment $employment)
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
     * @param Employment $employment
     * @return bool
     * @throws \Exception
     */
    public function update(User $user, Employment $employment)
    {
        // admin policy
        if ($user->hasAnyRole(['super-admin', 'moderator', 'writer'])) {
            return true;
        }

        if ($user->hasAnyPermission(['create articles', 'edit articles', 'publish articles'])) {
            return true;
        }
        return $user->id === $employment->user_id;
    }

    /**
     * @param User $user
     * @param Employment $employment
     * @return bool
     * @throws \Exception
     */
    public function delete(User $user, Employment $employment)
    {
        // admin policy
        if ($user->hasAnyRole(['super-admin', 'moderator', 'writer'])) {
            return true;
        }

        if ($user->hasAnyPermission(['create articles', 'edit articles', 'publish articles'])) {
            return true;
        }
        return $user->id === $employment->user_id;
    }

    /**
     * @param User $user
     * @param Employment $employment
     * @return bool
     * @throws \Exception
     */
    public function restore(User $user, Employment $employment)
    {
        // admin policy
        if ($user->hasAnyRole(['super-admin', 'moderator', 'writer'])) {
            return true;
        }

        if ($user->hasAnyPermission(['create articles', 'edit articles', 'publish articles'])) {
            return true;
        }
        return $user->id === $employment->user_id;
    }

    /**
     * @param User $user
     * @param Employment $employment
     * @return bool
     * @throws \Exception
     */
    public function forceDelete(User $user, Employment $employment)
    {
        // admin policy
        if ($user->hasAnyRole(['super-admin', 'moderator', 'writer'])) {
            return true;
        }

        if ($user->hasAnyPermission(['create articles', 'edit articles', 'publish articles'])) {
            return true;
        }
        return $user->id === $employment->user_id;
    }
}
