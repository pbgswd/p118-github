<?php

namespace App\Policies;

use Auth;
use App\Models\User;
use App\Models\Page;
use Illuminate\Auth\Access\HandlesAuthorization;

class PagePolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @return bool
     * @throws \Exception
     */
    public function viewAny(User $user)
    {
        if ($user->hasRole('super-admin')) {
            return true;
        }

        if ($user->hasAnyPermission(['create articles', 'edit articles', 'publish articles', 'unpublish articles'])) {
            return true;
        }
    }

    /**
     * Determine whether the user can view the page.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Page  $page
     * @return mixed
     */
    public function view(User $user, Page $page)
    {
        // no policy, public
    }

    /**
     * @param User $user
     * @return bool
     * @throws \Exception
     */
    public function create(User $user)
    {
        // admin policy
        if ($user->hasAnyRole(['super-admin', 'moderator', 'writer'])) {
            return true;
        }

        if ($user->hasAnyPermission(['create articles', 'edit articles', 'publish articles'])) {
            return true;
        }
    }

    /**
     * @param User $user
     * @param Page $page
     * @return bool
     * @throws \Exception
     */
    public function update(User $user, Page $page)
    {
        if ($user->hasAnyRole(['super-admin', 'moderator', 'writer'])) {
            return true;
        }

        if ($user->hasAnyPermission(['create articles', 'edit articles', 'publish articles', 'unpublish articles'])) {
            return true;
        }

        return $user->id === $page->user_id;
    }

    /**
     * @param User $user
     * @param Page $page
     * @return bool
     * @throws \Exception
     */
    public function delete(User $user, Page $page)
    {
        // admin moderator
        if ($user->hasAnyRole(['super-admin', 'moderator', 'writer'])) {
            return true;
        }

        if ($user->hasAnyPermission(['create articles', 'edit articles', 'publish articles', 'unpublish articles'])) {
            return true;
        }

        return $user->id === $page->user_id;
    }

    /**
     * Determine whether the user can restore the page.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Page  $page
     * @return mixed
     */
    public function restore(User $user, Page $page)
    {
        //admin
        if ($user->hasRole('super-admin')) {
            return true;
        }

        if ($user->can('delete articles')) {
            return true;
        }

        return $user->id === $page->user_id;
    }

    /**
     * Determine whether the user can permanently delete the page.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Page  $page
     * @return mixed
     */
    public function forceDelete(User $user, Page $page)
    {
        // admin
        if ($user->hasRole('super-admin')) {
            return true;
        }

        if ($user->can('delete articles')) {
            return true;
        }

        return $user->id === $page->user_id;
    }
}
