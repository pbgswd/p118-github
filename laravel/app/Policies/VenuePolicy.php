<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Venue;
use Illuminate\Auth\Access\HandlesAuthorization;

class VenuePolicy
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
     * Determine whether the user can view the venue.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Venue  $venue
     * @return mixed
     */
    public function view(User $user, Venue $venue)
    {

        if($venue->access_level == 'public' && $venue->live == 1){
            return true;
        }

        if ($venue->live == 1 && null !== $user) {
            return true;
        }

        // authors can view their own unpublished posts
        return $user->id == $venue->user_id;
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
     * @param Venue $venue
     * @return bool
     * @throws \Exception
     */
    public function update(User $user, Venue $venue)
    {
        // admin policy
        if ($user->hasAnyRole(['super-admin', 'moderator', 'writer'])) {
            return true;
        }

        if ($user->hasAnyPermission(['create articles', 'edit articles', 'publish articles'])) {
            return true;
        }
        return $user->id === $venue->user_id;
    }

    /**
     * @param User $user
     * @param Venue $venue
     * @return bool
     * @throws \Exception
     */
    public function delete(User $user, Venue $venue)
    {
        // admin moderator
        if ($user->hasAnyRole(['super-admin', 'moderator', 'writer'])) {
            return true;
        }

        if ($user->hasAnyPermission(['create articles', 'edit articles', 'publish articles', 'unpublish articles'])) {
            return true;
        }

        return $user->id === $venue->user_id;
    }

    /**
     * @param User $user
     * @param Venue $venue
     * @return bool
     * @throws \Exception
     */
    public function restore(User $user, Venue $venue)
    {
        // admin moderator
        if ($user->hasAnyRole(['super-admin', 'moderator', 'writer'])) {
            return true;
        }

        if ($user->hasAnyPermission(['create articles', 'edit articles', 'publish articles', 'unpublish articles'])) {
            return true;
        }

        return $user->id === $venue->user_id;
    }

    /**
     * @param User $user
     * @param Venue $venue
     * @return bool
     * @throws \Exception
     */
    public function forceDelete(User $user, Venue $venue)
    {
        // admin moderator
        if ($user->hasAnyRole(['super-admin', 'moderator', 'writer'])) {
            return true;
        }

        if ($user->hasAnyPermission(['create articles', 'edit articles', 'publish articles', 'unpublish articles'])) {
            return true;
        }

        return $user->id === $venue->user_id;
    }
}
