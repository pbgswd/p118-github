<?php

namespace App\Policies;

use App\Models\Agreement;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AgreementPolicy
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
     * Determine whether the user can view the agreement.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Agreement  $agreement
     * @return mixed
     */
    public function view(User $user, Agreement $agreement)
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
     * @param Agreement $agreement
     * @return bool
     * @throws \Exception
     */
    public function update(User $user, Agreement $agreement)
    {
        // admin policy
        if ($user->hasAnyRole(['super-admin', 'moderator', 'writer'])) {
            return true;
        }

        if ($user->hasAnyPermission(['create articles', 'edit articles', 'publish articles'])) {
            return true;
        }
        return $user->id === $agreement->user_id;
    }

    /**
     * @param User $user
     * @param Agreement $agreement
     * @return bool
     * @throws \Exception
     */
    public function delete(User $user, Agreement $agreement)
    {
        // admin policy
        if ($user->hasAnyRole(['super-admin', 'moderator', 'writer'])) {
            return true;
        }

        if ($user->hasAnyPermission(['create articles', 'edit articles', 'publish articles'])) {
            return true;
        }
        return $user->id === $agreement->user_id;
    }

    /**
     * @param User $user
     * @param Agreement $agreement
     * @return bool
     * @throws \Exception
     */
    public function restore(User $user, Agreement $agreement)
    {
        // admin policy
        if ($user->hasAnyRole(['super-admin', 'moderator', 'writer'])) {
            return true;
        }

        if ($user->hasAnyPermission(['create articles', 'edit articles', 'publish articles'])) {
            return true;
        }
        return $user->id === $agreement->user_id;
    }

    /**
     * @param User $user
     * @param Agreement $agreement
     * @return bool
     * @throws \Exception
     */
    public function forceDelete(User $user, Agreement $agreement)
    {
        // admin policy
        if ($user->hasAnyRole(['super-admin', 'moderator', 'writer'])) {
            return true;
        }

        if ($user->hasAnyPermission(['create articles', 'edit articles', 'publish articles'])) {
            return true;
        }
        return $user->id === $agreement->user_id;
    }
}
