<?php

namespace App\Policies;

use Auth;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;



class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models users.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the models user.
     *
     * @param  \App\Models\User  $user
     * @param  \User  $user
     * @return mixed
     */
    public function view(User $user, User $userRequest)
    {
        //
    }

    /**
     * Determine whether the user can create models users.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the models user.
     *
     * @param  \App\Models\User  $user
     * @param  \User  $user
     * @return mixed
     */
    public function update(User $user)
    {
        return true;
       // return $user->id === $userRequest->id;
    }

    /**
     * Determine whether the user can delete the models user.
     *
     * @param  \App\Models\User  $user
     * @param  \User  $user
     * @return mixed
     */
    public function delete(User $user, User $userRequest)
    {
        //
    }

    /**
     * Determine whether the user can restore the models user.
     *
     * @param  \App\Models\User  $user
     * @param  \User  $user
     * @return mixed
     */
    public function restore(User $user, User $userRequest)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the models user.
     *
     * @param  \App\Models\User  $user
     * @param  \User  $user
     * @return mixed
     */
    public function forceDelete(User $user, User $userRequest)
    {
        //
    }
}
