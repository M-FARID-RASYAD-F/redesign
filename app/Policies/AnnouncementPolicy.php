<?php

namespace App\Policies;

use App\Models\Announcement;
use App\Models\User;

class AnnouncementPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->is_active;
    }

    public function view(User $user, Announcement $announcement): bool
    {
        return $user->is_active;
    }

    public function create(User $user): bool
    {
        return $user->is_active && in_array($user->role, ['super_admin', 'admin_cms']);
    }

    public function update(User $user, Announcement $announcement): bool
    {
        return $user->is_active && in_array($user->role, ['super_admin', 'admin_cms']);
    }

    public function delete(User $user, Announcement $announcement): bool
    {
        return $user->is_active && in_array($user->role, ['super_admin', 'admin_cms']);
    }
}
