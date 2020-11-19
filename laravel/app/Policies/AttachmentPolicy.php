<?php

namespace App\Policies;

use App\Models\Attachment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AttachmentPolicy
{
    use HandlesAuthorization;

    public function before()
    {

    }

    /**
     * @param User $user
     * @return bool
     * @throws \Exception
     */
    public function viewAny(User $user)
    {
        //todo https://laravel.com/docs/6.x/authorization#policy-responses

        if ($user->hasRole('super-admin')) {
            return true;
        }

        if ($user->hasAnyPermission(['create articles', 'edit articles', 'publish articles', 'unpublish articles'])) {
            return true;
        }
    }

    /**
     * Determine whether the user can view the attachment.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Attachment  $attachment
     * @return mixed
     */
    public function view(User $user, Attachment $attachment)
    {
        //
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
     * @param Attachment $attachment
     * @return bool
     * @throws \Exception
     */
    public function update(User $user, Attachment $attachment)
    {
        // admin policy
        if ($user->hasAnyRole(['super-admin', 'moderator', 'writer'])) {
            return true;
        }

        if ($user->hasAnyPermission(['create articles', 'edit articles', 'publish articles'])) {
            return true;
        }
        return $user->id === $attachment->user_id;
    }

    /**
     * @param User $user
     * @param Attachment $attachment
     * @return bool
     * @throws \Exception
     */
    public function delete(User $user, Attachment $attachment)
    {
        // admin policy
        if ($user->hasAnyRole(['super-admin', 'moderator', 'writer'])) {
            return true;
        }

        if ($user->hasAnyPermission(['create articles', 'edit articles', 'publish articles', 'delete articles'])) {
            return true;
        }
        return $user->id === $attachment->user_id;
    }

    /**
     * @param User $user
     * @param Attachment $attachment
     * @return bool
     * @throws \Exception
     */
    public function restore(User $user, Attachment $attachment)
    {
        // admin policy
        if ($user->hasAnyRole(['super-admin', 'moderator', 'writer'])) {
            return true;
        }

        if ($user->hasAnyPermission(['create articles', 'edit articles', 'publish articles', 'delete articles'])) {
            return true;
        }
        return $user->id === $attachment->user_id;
    }

    /**
     * @param User $user
     * @param Attachment $attachment
     * @return bool
     * @throws \Exception
     */
    public function forceDelete(User $user, Attachment $attachment)
    {
        // admin policy
        if ($user->hasAnyRole(['super-admin', 'moderator', 'writer'])) {
            return true;
        }

        if ($user->hasAnyPermission(['create articles', 'edit articles', 'publish articles', 'delete articles'])) {
            return true;
        }
        return $user->id === $attachment->user_id;
    }
}
