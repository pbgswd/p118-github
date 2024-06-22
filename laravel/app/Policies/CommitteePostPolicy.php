<?php

namespace App\Policies;

use App\CommitteePost;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommitteePostPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @return mixed
     */
    public function viewAny(User $user): bool
    {
        return $user;
    }

    /**
     * @return bool
     */
    public function view(User $user): bool
    {
        return $user;
    }

    /**
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
     * Determine whether the user can delete the model.
     *
     * @param  CommitteePost  $committeePost
     * @return mixed
     */
    public function delete(User $user, CommitteePost $committeePost): bool
    {
        return ($user->id == $committeePost->user_id) ||
            $user->hasPermissionTo('manage committee') ||
            ($user->hasAnyRole(['super-admin']) ||
                $user->hasPermissionTo('create committee'));
    }
}
