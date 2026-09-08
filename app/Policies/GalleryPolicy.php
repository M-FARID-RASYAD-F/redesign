<?php

namespace App\Policies;

use App\Models\Gallery;
use App\Models\User;

class GalleryPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->is_active;
    }

    public function view(User $user, Gallery $gallery): bool
    {
        return $user->is_active;
    }

    public function create(User $user): bool
    {
        return $user->is_active && in_array($user->role, ['super_admin', 'admin_cms']);
    }

    public function update(User $user, Gallery $gallery): bool
    {
        return $user->is_active && in_array($user->role, ['super_admin', 'admin_cms']);
    }

    public function delete(User $user, Gallery $gallery): bool
    {
        return $user->is_active && in_array($user->role, ['super_admin', 'admin_cms']);
    }
}
