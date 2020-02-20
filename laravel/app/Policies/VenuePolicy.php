<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Venue;
use Illuminate\Auth\Access\HandlesAuthorization;

class VenuePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any venues.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
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
        //
    }

    /**
     * Determine whether the user can create venues.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the venue.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Venue  $venue
     * @return mixed
     */
    public function update(User $user, Venue $venue)
    {
        //
    }

    /**
     * Determine whether the user can delete the venue.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Venue  $venue
     * @return mixed
     */
    public function delete(User $user, Venue $venue)
    {
        //
    }

    /**
     * Determine whether the user can restore the venue.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Venue  $venue
     * @return mixed
     */
    public function restore(User $user, Venue $venue)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the venue.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Venue  $venue
     * @return mixed
     */
    public function forceDelete(User $user, Venue $venue)
    {
        //
    }
}
