<?php

namespace App\Policies;

use App\CommitteePost;
use App\Models\Committee;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommitteePostPolicy
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
        return $user;
    }

    /**
     * @param User $user
     * @return bool
     */
    public function view(User $user)
    {
        return $user;
    }

    /**
     * @param User $user
     * @param $committee
     * @return bool
     */
    public function create(User $user, $committee)
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
    public function update(User $user, $committeePost)
    {
        return ($user->id == $committeePost->user_id) ||
            $user->hasPermissionTo('manage committee') ||
            ($user->hasAnyRole(['super-admin']) ||
                $user->hasPermissionTo('create committee'));
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param CommitteePost $committeePost
     * @return mixed
     */
    public function delete(User $user, $committeePost)
    {
        return ($user->id == $committeePost->user_id) ||
            $user->hasPermissionTo('manage committee') ||
            ($user->hasAnyRole(['super-admin']) ||
                $user->hasPermissionTo('create committee'));
    }

}
