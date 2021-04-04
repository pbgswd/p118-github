<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class PostPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @return bool
     * @throws \Exception
     */
    public function viewAny(User $user)
    {
        return $user->hasRole(['super-admin', 'writer']) ||
            $user->hasAnyPermission(['create articles', 'edit articles', 'publish articles', 'unpublish articles']);
    }

    /**
     * Determine whether the user can view the post.
     *
     * @param User $user
     * @param Post $post
     * @return mixed
     */
    public function view(User $user, Post $post)
    {
      //  dd([$user, $post]);
    }

    /**
     * @param User $user
     * @return bool
     * @throws \Exception
     */
    public function create(User $user)
    {
        return $user->hasRole(['super-admin', 'writer']) || $user->hasPermission(['create articles']);
    }

    /**
     * @param User $user
     * @return bool
     * @throws \Exception
     */
    public function update(User $user)
    {
        return $user->hasRole(['super-admin', 'writer']) || $user->hasPermission(['update articles']);
    }

    /**
     * @param User $user
     * @return bool
     * @throws \Exception
     */
    public function delete(User $user)
    {
        // admin moderator
        return $user->hasRole(['super-admin', 'writer']) || $user->hasPermission(['delete articles']);
    }

    /**
     * @param User $user
     * @return bool
     */
    public function restore(User $user)
    {
        return $user->hasRole(['super-admin', 'writer']) || $user->hasPermission(['create articles']);
    }

    /**
     * @param User $user
     * @return bool
     */
    public function forceDelete(User $user)
    {
        return $user->hasRole(['super-admin', 'writer']) || $user->hasPermission(['delete articles']);
    }
}
