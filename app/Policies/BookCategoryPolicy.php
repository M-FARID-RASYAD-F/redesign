<?php
namespace App\Policies;

use App\Models\BookCategory;
use App\Models\User;

class BookCategoryPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->is_active && in_array($user->role, ['super_admin', 'admin_perpus']);
    }

    public function view(User $user, BookCategory $category): bool
    {
        return $user->is_active;
    }

    public function create(User $user): bool
    {
        return $user->is_active && in_array($user->role, ['super_admin', 'admin_perpus']);
    }

    public function update(User $user, BookCategory $category): bool
    {
        return $user->is_active && in_array($user->role, ['super_admin', 'admin_perpus']);
    }

    public function delete(User $user, BookCategory $category): bool
    {
        return $user->is_active && in_array($user->role, ['super_admin', 'admin_perpus']);
    }
}
