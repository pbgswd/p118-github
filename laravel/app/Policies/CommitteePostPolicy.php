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
     * @return bool
     */
    public function create(User $user)
    {
        /**
         * allow committee member to create content
         * must be active member of THIS COMMITTEE
         * allow super-admin to create content
         */
        //todo filter the committee membership for user
       // dd(['func_get_args' => func_get_args()]);

        return
            $user !== null ||
            $user->hasPermissionTo('manage committee') ||
            $user->hasAnyRole(['super-admin']) ||
            $user->hasPermissionTo('create committee');
    }

    /**
     * @param User $user
     * @param Committee $committee
     * @param CommitteePost $committeePost
     * @return bool
     */
    public function update(User $user, Committee $committee, CommitteePost $committeePost)
    {
        return ($committee->active_committee_members->find($user->id) !== null) ||
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
    public function delete(User $user, CommitteePost $committeePost)
    {
        //todo delete method
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param CommitteePost $committeePost
     * @return mixed
     */
    public function restore(User $user, CommitteePost $committeePost)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param CommitteePost $committeePost
     * @return mixed
     */
    public function forceDelete(User $user, CommitteePost $committeePost)
    {
        //
    }
}
