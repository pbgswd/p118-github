<?php

namespace App\Policies;

use Auth;
use App\Models\User;
use App\Models\Page;
use Illuminate\Auth\Access\HandlesAuthorization;

class PagePolicy
{
    use HandlesAuthorization;

    /*
     * methods in PageController:
     *  index list create store show edit update destroy
     */

    /**
     * Determine whether the user can view the page.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Page  $page
     * @return mixed
     */
    public function view(User $user, Page $page)
    {
        //
    }

    /**
     * Determine whether the user can create pages.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the page.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Page  $page
     * @return mixed
     */
    public function update(User $user, Page $page)
    {
        return $user->id === $page->user_id;
    }

    /**
     * Determine whether the user can delete the page.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Page  $page
     * @return mixed
     */
    public function delete(User $user, Page $page)
    {
        //
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
        //
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
        //
    }
}
