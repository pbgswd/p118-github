<?php

namespace App\Policies;

use App\Models\Topics;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TopicPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any topics.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return false;
        //admin
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
     * Determine whether the user can create topics.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //admin
    }

    /**
     * Determine whether the user can update the topics.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Topics  $topics
     * @return mixed
     */
    public function update(User $user, Topics $topics)
    {
        //admin
    }

    /**
     * Determine whether the user can delete the topics.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Topics  $topics
     * @return mixed
     */
    public function delete(User $user, Topics $topics)
    {
        //admin
    }

    /**
     * Determine whether the user can restore the topics.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Topics  $topics
     * @return mixed
     */
    public function restore(User $user, Topics $topics)
    {
        //admin
    }

    /**
     * Determine whether the user can permanently delete the topics.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Topics  $topics
     * @return mixed
     */
    public function forceDelete(User $user, Topics $topics)
    {
        //admin
    }
}
