<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class InviteUserPolicy
{
    use HandlesAuthorization;

    public function before($user): bool
    {
        $test = $user->hasRole(['super-admin', 'office']) || $user->hasPermissionTo('create users');
        if ($test) {
            return true;
        }
    }

    public function viewAny(User $user): bool
    {
        return $user->hasRole('super-admin') ||
            $user->hasPermissionTo('create users');
    }

    public function view(User $user): bool
    {
        return $user->hasRole('super-admin') ||
            $user->hasPermissionTo('create users');
    }

    public function create(User $user): bool
    {
        return $user->hasRole(['super-admin', 'office']) ||
            $user->hasPermissionTo('create users');
    }

    public function update(User $user): bool
    {
        return $user->hasRole(['super-admin', 'office']) ||
            $user->hasPermissionTo('edit users');
    }

    public function delete(User $user): bool
    {
        return $user->hasRole(['super-admin', 'office']) ||
            $user->hasPermissionTo('edit users');
    }

    public function restore(User $user): bool
    {
        return $user->hasRole(['super-admin', 'office']) ||
            $user->hasPermissionTo('edit users');
    }

    public function forceDelete(User $user): bool
    {
        return $user->hasRole(['super-admin', 'office']) ||
            $user->hasPermissionTo('delete users');
    }
}
