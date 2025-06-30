<?php

namespace App\Policies;

use App\Models\CommitteePost;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommitteePostPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): User|bool
    {
        return $user;
    }

    public function view(User $user): User|bool
    {
        return $user;
    }

    public function create(User $user, $committee): bool
    {
        return $committee->active_committee_members->find($user->id) !== null ||
            $user->hasPermissionTo('manage committee') ||
            $user->hasAnyRole(['super-admin']) ||
            $user->hasPermissionTo('create committee');
    }

    public function update(User $user, $committeePost): bool
    {
        return ($user->id == $committeePost->user_id) ||
            $user->hasPermissionTo('manage committee') ||
            ($user->hasAnyRole(['super-admin']) ||
                $user->hasPermissionTo('create committee'));
    }

    public function delete(User $user, CommitteePost $committeePost): bool
    {
        return ($user->id == $committeePost->user_id) ||
            $user->hasPermissionTo('manage committee') ||
            ($user->hasAnyRole(['super-admin']) ||
                $user->hasPermissionTo('create committee'));
    }
}
