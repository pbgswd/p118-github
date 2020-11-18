<?php

namespace App\Policies;

use App\ExecutiveMembership;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ExecutiveMembershipPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasRole(['super-admin', 'office']) ||
            $user->hasAnyPermission(['create users', 'edit users', 'publish users', 'unpublish users']);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param ExecutiveMembership $executiveMembership
     * @return mixed
     */
    public function view(User $user)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasRole(['super-admin', 'office']) || $user->hasPermissionTo('create users');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param ExecutiveMembership $executiveMembership
     * @return mixed
     */
    public function update(User $user)
    {
        return $user->hasRole(['super-admin', 'office']) || $user->hasPermissionTo('update users');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param ExecutiveMembership $executiveMembership
     * @return mixed
     */
    public function delete(User $user)
    {
        return $user->hasRole(['super-admin', 'office']) || $user->hasPermissionTo('delete users');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param ExecutiveMembership $executiveMembership
     * @return mixed
     */
    public function restore(User $user)
    {
        return $user->hasRole(['super-admin', 'office']) || $user->hasPermissionTo('create users');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param ExecutiveMembership $executiveMembership
     * @return mixed
     */
    public function forceDelete(User $user)
    {
        return $user->hasRole(['super-admin', 'office']) || $user->hasPermissionTo('delete users');
    }
}
