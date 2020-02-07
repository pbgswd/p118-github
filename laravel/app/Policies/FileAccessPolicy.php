<?php

namespace App\Policies;

use App\Attachment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FileAccessPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any attachments.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the attachment.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Attachment  $attachment
     * @return mixed
     */
    public function view(User $user, Attachment $attachment)
    {
        //
    }

    /**
     * Determine whether the user can create attachments.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the attachment.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Attachment  $attachment
     * @return mixed
     */
    public function update(User $user, Attachment $attachment)
    {
        //
    }

    /**
     * Determine whether the user can delete the attachment.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Attachment  $attachment
     * @return mixed
     */
    public function delete(User $user, Attachment $attachment)
    {
        //
    }

    /**
     * Determine whether the user can restore the attachment.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Attachment  $attachment
     * @return mixed
     */
    public function restore(User $user, Attachment $attachment)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the attachment.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Attachment  $attachment
     * @return mixed
     */
    public function forceDelete(User $user, Attachment $attachment)
    {
        //
    }
}
