<?php

namespace App\Policies;

use App\Models\PpdbDocument;
use App\Models\User;

class PpdbDocumentPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->is_active;
    }

    public function view(User $user, PpdbDocument $document): bool
    {
        return $user->is_active;
    }

    public function verify(User $user, PpdbDocument $document): bool
    {
        return $user->is_active && in_array($user->role, ['super_admin', 'admin_ppdb']);
    }

    public function update(User $user, PpdbDocument $document): bool
    {
        return $user->is_active && in_array($user->role, ['super_admin', 'admin_ppdb']);
    }

    public function delete(User $user, PpdbDocument $document): bool
    {
        return $user->is_active && $user->role === 'super_admin';
    }
}
