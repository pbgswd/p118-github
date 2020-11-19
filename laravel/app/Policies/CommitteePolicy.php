<?php

namespace App\Policies;

use App\Models\Committee;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommitteePolicy
{
    use HandlesAuthorization;

    /**
     * @param $user
     * @param $ability
     * @return bool
     */
    public function before($user, $ability)
    {
 //
    }


    /**
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user)
    {
        return $user->hasAnyRole(['super-admin', 'writer'])||
            $user->hasAnyPermission(['create articles', 'edit articles', 'publish articles']);
    }

    /**
     * @param User $user
     * @return bool
     */
    public function view(User $user)
    {
        return $user->hasAnyRole(['super-admin', 'writer'])||
            $user->hasAnyPermission(['create articles', 'edit articles', 'publish articles']);
    }

    /**
     * @param User $user
     * @return bool
     */
    public function create(User $user)
    {
        return $user->hasAnyRole(['super-admin', 'writer'])||
            $user->hasAnyPermission(['create articles', 'edit articles',
                'publish articles']);
    }

    /**
     * @param User $user
     * @param Committee $committee
     * @return bool
     */
    public function update(User $user, Committee $committee)
    {
//either admin or user is member of this admin, and executive
        return $user->hasAnyRole(['super-admin', 'writer'])||
            $user->hasAnyPermission(['create articles', 'edit articles', 'publish articles']);
    }

    /**
     * @param User $user
     * @param Committee $committee
     * @return bool
     * @throws \Exception
     */
    public function delete(User $user, Committee $committee)
    {
        // admin policy
        return $user->hasAnyRole(['super-admin', 'writer'])||
            $user->hasAnyPermission(['create articles', 'edit articles', 'publish articles']) ||
            $user->id === $committee->user_id;
    }

    /**
     * @param User $user
     * @param Committee $committee
     * @return bool
     * @throws \Exception
     */
    public function restore(User $user, Committee $committee)
    {
        return $user->hasAnyRole(['super-admin', 'writer'])||
            $user->hasAnyPermission(['create articles', 'edit articles', 'publish articles']) ||
            $user->id === $committee->user_id;
    }

    /**
     * @param User $user
     * @param Committee $committee
     * @return bool
     * @throws \Exception
     */
    public function forceDelete(User $user, Committee $committee)
    {
        return $user->hasAnyRole(['super-admin', 'writer'])||
            $user->hasAnyPermission(['create articles', 'edit articles', 'publish articles']) ||
            $user->id === $committee->user_id;
    }
}
