<?php
namespace App\Policies;

use App\Models\BookLoan;
use App\Models\User;

class BookLoanPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->is_active && in_array($user->role, ['super_admin', 'admin_perpus']);
    }

    public function view(User $user, BookLoan $loan): bool
    {
        return $user->is_active;
    }

    public function update(User $user, BookLoan $loan): bool
    {
        return $user->is_active && in_array($user->role, ['super_admin', 'admin_perpus']);
    }

    public function delete(User $user, BookLoan $loan): bool
    {
        return $user->is_active && in_array($user->role, ['super_admin', 'admin_perpus']);
    }
}
