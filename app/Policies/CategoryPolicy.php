<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;

class CategoryPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->is_active && in_array($user->role, ['super_admin', 'admin_cms', 'admin_perpus', 'editor_akademik']);
    }

    public function view(User $user, Category $category): bool
    {
        return $user->is_active;
    }

    public function create(User $user): bool
    {
        return $user->is_active && in_array($user->role, ['super_admin', 'admin_cms', 'admin_perpus']);
    }

    public function update(User $user, Category $category): bool
    {
        return $user->is_active && in_array($user->role, ['super_admin', 'admin_cms', 'admin_perpus']);
    }

    public function delete(User $user, Category $category): bool
    {
        return $user->is_active && in_array($user->role, ['super_admin', 'admin_perpus']);
    }
}
