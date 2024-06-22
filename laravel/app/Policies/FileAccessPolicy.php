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
     * @return mixed
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the attachment.
     *
     * @return mixed
     */
    public function view(User $user, Attachment $attachment): bool
    {
        //
    }

    /**
     * Determine whether the user can create attachments.
     *
     * @return mixed
     */
    public function create(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can update the attachment.
     *
     * @return mixed
     */
    public function update(User $user, Attachment $attachment): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the attachment.
     *
     * @return mixed
     */
    public function delete(User $user, Attachment $attachment): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the attachment.
     *
     * @return mixed
     */
    public function restore(User $user, Attachment $attachment): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the attachment.
     *
     * @return mixed
     */
    public function forceDelete(User $user, Attachment $attachment): bool
    {
        //
    }
}
