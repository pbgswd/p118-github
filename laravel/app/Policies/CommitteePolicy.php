<?php

namespace App\Policies;

use App\Models\Committee;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommitteePolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['super-admin', 'writer', 'committee']) ||
            $user->hasAnyPermission(['create committee', 'manage committee', 'delete committee']);
    }

    /**
     * @param User $user
     * @param Committee $committee
     * @return bool
     */
    public function view(User $user, Committee $committee)
    {
        return $user->hasAnyRole(['super-admin', 'writer', 'committee']) ||
            $user->hasAnyPermission(['create committee', 'manage committee', 'delete committee']);
    }

    /**
     * @param User $user
     * @return bool
     */
    public function create(User $user)
    {
        return $user->hasAnyRole(['super-admin']) ||
            $user->hasPermissionTo('create committee');
    }

    /**
     * @param User $user
     * @param Committee $committee
     * @return bool
     */
    public function update(User $user, Committee $committee): bool
    {
        return ($user->hasPermissionTo('manage committee') &&
            ($committee->active_committee_members->find($user->id) !== null)) ||
            ($user->hasAnyRole(['super-admin']) ||
            $user->hasPermissionTo('create committee'));
    }

    /**
     * @param User $user
     * @return bool
     * @throws \Exception
     */
    public function delete(User $user)
    {
        // admin policy
        return $user->hasAnyRole(['super-admin']) ||
            $user->hasPermissionTo('delete committee');
    }

    /**
     * @param User $user
     * @return bool
     * @throws \Exception
     */
    public function restore(User $user)
    {
        return $user->hasAnyRole(['super-admin']) ||
            $user->hasPermissionTo('create committee');
    }

    /**
     * @param User $user
     * @return bool
     * @throws \Exception
     */
    public function forceDelete(User $user)
    {
        return $user->hasAnyRole(['super-admin']) ||
            $user->hasPermissionTo('delete committee');
    }
}
