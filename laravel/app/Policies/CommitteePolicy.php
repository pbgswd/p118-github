<?php

namespace App\Policies;

use App\Models\Committee;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommitteePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['super-admin', 'writer', 'committee']) ||
            $user->hasAnyPermission(['create committee', 'manage committee', 'delete committee']);
    }

    /**
     * @return bool
     */
    public function view(User $user, Committee $committee): bool
    {
        return $user->hasAnyRole(['super-admin', 'writer', 'committee']) ||
            $user->hasAnyPermission(['create committee', 'manage committee']);
    }

    /**
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->hasAnyRole(['super-admin']) ||
            $user->hasPermissionTo('create committee');
    }

    public function update(User $user, Committee $committee): bool
    {
        return ($user->hasPermissionTo('manage committee') &&
            ($committee->active_committee_members->find($user->id) !== null)) ||
            ($user->hasAnyRole(['super-admin']) ||
            $user->hasPermissionTo('create committee'));
    }

    /**
     * @return bool
     *
     * @throws \Exception
     */
    public function delete(User $user): bool
    {
        // admin policy
        return $user->hasAnyRole(['super-admin']);
    }

    /**
     * @return bool
     *
     * @throws \Exception
     */
    public function restore(User $user): bool
    {
        return $user->hasAnyRole(['super-admin']) ||
            $user->hasPermissionTo('create committee');
    }

    /**
     * @return bool
     *
     * @throws \Exception
     */
    public function forceDelete(User $user): bool
    {
        return $user->hasAnyRole(['super-admin']);
    }
}
