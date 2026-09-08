<?php

namespace App\Policies;

use App\Models\PpdbRegistration;
use App\Models\User;

class PpdbRegistrationPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->is_active && in_array($user->role, ['super_admin', 'admin_ppdb', 'admin_cms']);
    }

    public function view(User $user, PpdbRegistration $registration): bool
    {
        return $user->is_active;
    }

    public function update(User $user, PpdbRegistration $registration): bool
    {
        return $user->is_active && in_array($user->role, ['super_admin', 'admin_ppdb']);
    }

    public function verify(User $user, PpdbRegistration $registration): bool
    {
        return $user->is_active && in_array($user->role, ['super_admin', 'admin_ppdb']);
    }

    public function export(User $user): bool
    {
        return $user->is_active && in_array($user->role, ['super_admin', 'admin_ppdb']);
    }

    /**
     * Khusus super_admin (admin_ppdb tidak diizinkan menghapus data pendaftar sesuai role.md).
     */
    public function delete(User $user, PpdbRegistration $registration): bool
    {
        return $user->is_active && $user->role === 'super_admin';
    }
}
