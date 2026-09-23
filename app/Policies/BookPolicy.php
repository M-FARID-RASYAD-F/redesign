<?php
namespace App\Policies;

use App\Models\Book;
use App\Models\User;

class BookPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->is_active && in_array($user->role, ['super_admin', 'admin_perpus']);
    }

    public function view(User $user, Book $book): bool
    {
        return $user->is_active;
    }

    public function create(User $user): bool
    {
        return $user->is_active && in_array($user->role, ['super_admin', 'admin_perpus']);
    }

    public function update(User $user, Book $book): bool
    {
        return $user->is_active && in_array($user->role, ['super_admin', 'admin_perpus']);
    }

    public function delete(User $user, Book $book): bool
    {
        return $user->is_active && in_array($user->role, ['super_admin', 'admin_perpus']);
    }
}
