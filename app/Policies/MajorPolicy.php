<?php

namespace App\Policies;

use App\Models\Major;
use App\Models\User;

class MajorPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->is_active && in_array($user->role, ['super_admin', 'admin_cms', 'editor_akademik']);
    }

    public function view(User $user, Major $major): bool
    {
        return $user->is_active;
    }

    public function create(User $user): bool
    {
        return $user->is_active && in_array($user->role, ['super_admin', 'admin_cms', 'editor_akademik']);
    }

    public function update(User $user, Major $major): bool
    {
        return $user->is_active && in_array($user->role, ['super_admin', 'admin_cms', 'editor_akademik']);
    }

    public function delete(User $user, Major $major): bool
    {
        return $user->is_active && in_array($user->role, ['super_admin', 'admin_cms', 'editor_akademik']);
    }
}
