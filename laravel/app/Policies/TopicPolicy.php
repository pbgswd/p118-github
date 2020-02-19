<?php

namespace App\Policies;

use App\Models\Topics;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TopicPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @return bool
     * @throws \Exception
     */
    public function viewAny(User $user)
    {
        //admin
        if ($user->hasRole('super-admin')) {
            return true;
        }

        if ($user->hasAnyPermission(['create articles', 'edit articles', 'publish articles', 'unpublish articles'])) {
            return true;
        }
    }

    /**
     * Determine whether the user can view the topics.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Topics  $topics
     * @return mixed
     */
    public function view(User $user, Topics $topics)
    {
        //public
    }

    /**
     * @param User $user
     * @return bool
     * @throws \Exception
     */
    public function create(User $user)
    {
        //admin

        if ($user->hasRole('super-admin')) {
            return true;
        }

        if ($user->hasAnyPermission(['create articles', 'edit articles', 'publish articles', 'unpublish articles'])) {
            return true;
        }
    }

    /**
     * @param User $user
     * @param Topics $topics
     * @return bool
     * @throws \Exception
     */
    public function update(User $user, Topics $topics)
    {
        //admin
        if ($user->hasRole('super-admin')) {
            return true;
        }

        if ($user->hasAnyPermission(['create articles', 'edit articles', 'publish articles', 'unpublish articles'])) {
            return true;
        }
    }

    /**
     * @param User $user
     * @param Topics $topics
     * @return bool
     * @throws \Exception
     */
    public function delete(User $user, Topics $topics)
    {
        //admin
        if ($user->hasRole('super-admin')) {
            return true;
        }

        if ($user->hasAnyPermission(['create articles', 'edit articles', 'publish articles', 'unpublish articles'])) {
            return true;
        }
    }

    /**
     * @param User $user
     * @param Topics $topics
     * @return bool
     * @throws \Exception
     */
    public function restore(User $user, Topics $topics)
    {
        //admin
        if ($user->hasRole('super-admin')) {
            return true;
        }

        if ($user->hasAnyPermission(['create articles', 'edit articles', 'publish articles', 'unpublish articles'])) {
            return true;
        }
    }

    /**
     * @param User $user
     * @param Topics $topics
     * @return bool
     * @throws \Exception
     */
    public function forceDelete(User $user, Topics $topics)
    {
        //admin
        if ($user->hasRole('super-admin')) {
            return true;
        }

        if ($user->hasAnyPermission(['create articles', 'edit articles', 'publish articles', 'unpublish articles'])) {
            return true;
        }
    }
}
