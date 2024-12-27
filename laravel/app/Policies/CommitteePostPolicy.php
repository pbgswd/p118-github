<?php

namespace App\Policies;

use App\Models\CommitteePost;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommitteePostPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @return User|bool
     */
    public function viewAny(User $user): User|bool
    {
        return $user;
    }

    /**
     * @param User $user
     * @return User|bool
     */
    public function view(User $user): User|bool
    {
        return $user;
    }

    /**
     * @param User $user
     * @param $committee
     * @return bool
     */
    public function create(User $user, $committee): bool
    {
        return $committee->active_committee_members->find($user->id) !== null ||
            $user->hasPermissionTo('manage committee') ||
            $user->hasAnyRole(['super-admin']) ||
            $user->hasPermissionTo('create committee');
    }

    /**
     * @param User $user
     * @param $committeePost
     * @return bool
     */
    public function update(User $user, $committeePost): bool
    {
        return ($user->id == $committeePost->user_id) ||
            $user->hasPermissionTo('manage committee') ||
            ($user->hasAnyRole(['super-admin']) ||
                $user->hasPermissionTo('create committee'));
    }

    /**
     * @param User $user
     * @param CommitteePost $committeePost
     * @return bool
     */
    public function delete(User $user, CommitteePost $committeePost): bool
    {
        return ($user->id == $committeePost->user_id) ||
            $user->hasPermissionTo('manage committee') ||
            ($user->hasAnyRole(['super-admin']) ||
                $user->hasPermissionTo('create committee'));
    }
}
