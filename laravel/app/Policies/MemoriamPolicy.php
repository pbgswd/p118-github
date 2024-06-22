<?php

namespace App\Policies;

use App\Models\Memoriam;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MemoriamPolicy
{
    use HandlesAuthorization;

    /**
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
     * @return mixed
     */
    public function view(User $user, Memoriam $memoriam)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasRole(['super-admin', 'office']) ||
            $user->hasPermissionTo('create users');
    }

    /**
     * @return bool
     */
    public function update(User $user, Memoriam $memoriam)
    {
        return $user->hasRole(['super-admin', 'office']) ||
            $user->hasPermissionTo('create users');
    }

    /**
     * @return bool
     */
    public function delete(User $user, Memoriam $memoriam)
    {
        return $user->hasRole(['super-admin', 'office']) ||
            $user->hasPermissionTo('create users');
    }

    /**
     * @return bool
     */
    public function restore(User $user, Memoriam $memoriam)
    {
        return $user->hasRole(['super-admin', 'office']) ||
            $user->hasPermissionTo('create users');
    }

    /**
     * @return bool
     */
    public function forceDelete(User $user, Memoriam $memoriam)
    {
        return $user->hasRole(['super-admin', 'office']) ||
            $user->hasPermissionTo('create users');
    }
}
