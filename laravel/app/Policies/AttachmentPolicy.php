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
     * @return bool
     *
     * @throws \Exception
     */
    public function viewAny(User $user): bool
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
     * @return mixed
     */
    public function view(User $user, Attachment $attachment): bool
    {
        //
    }

    /**
     * @return bool
     *
     * @throws \Exception
     */
    public function create(User $user): bool
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
     * @return bool
     *
     * @throws \Exception
     */
    public function update(User $user, Attachment $attachment): bool
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
     * @return bool
     *
     * @throws \Exception
     */
    public function delete(User $user, Attachment $attachment): bool
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
     * @return bool
     *
     * @throws \Exception
     */
    public function restore(User $user, Attachment $attachment): bool
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
     * @return bool
     *
     * @throws \Exception
     */
    public function forceDelete(User $user, Attachment $attachment): bool
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
