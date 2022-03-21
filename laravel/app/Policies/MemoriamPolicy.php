<?php

namespace App\Policies;

use App\Models\Memoriam;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MemoriamPolicy
{
    use HandlesAuthorization;

    /**
     * @param $user
     * @param $ability
     * @return bool
     */
    public function before($user, $ability)
    {
        $test = $user->hasRole(['super-admin', 'office']) || $user->hasPermissionTo('create users');
        if ($test) {
            return true;
        }
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasRole(['super-admin', 'office']) ||
            $user->hasPermissionTo('create users');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Memoriam  $memoriam
     * @return mixed
     */
    public function view(User $user, Memoriam $memoriam)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasRole(['super-admin', 'office']) ||
            $user->hasPermissionTo('create users');
    }

    /**
     * @param User $user
     * @param Memoriam $memoriam
     * @return bool
     */
    public function update(User $user, Memoriam $memoriam)
    {
        return $user->hasRole(['super-admin', 'office']) ||
            $user->hasPermissionTo('create users');
    }

    /**
     * @param User $user
     * @param Memoriam $memoriam
     * @return bool
     */
    public function delete(User $user, Memoriam $memoriam)
    {
        return $user->hasRole(['super-admin', 'office']) ||
            $user->hasPermissionTo('create users');
    }

    /**
     * @param User $user
     * @param Memoriam $memoriam
     * @return bool
     */
    public function restore(User $user, Memoriam $memoriam)
    {
        return $user->hasRole(['super-admin', 'office']) ||
            $user->hasPermissionTo('create users');
    }

    /**
     * @param User $user
     * @param Memoriam $memoriam
     * @return bool
     */
    public function forceDelete(User $user, Memoriam $memoriam)
    {
        return $user->hasRole(['super-admin', 'office']) ||
            $user->hasPermissionTo('create users');
    }
}
