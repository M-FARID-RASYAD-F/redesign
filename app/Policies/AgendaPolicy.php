<?php

namespace App\Policies;

use App\Models\Agenda;
use App\Models\User;

class AgendaPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->is_active;
    }

    public function view(User $user, Agenda $agenda): bool
    {
        return $user->is_active;
    }

    public function create(User $user): bool
    {
        return $user->is_active && in_array($user->role, ['super_admin', 'admin_cms']);
    }

    public function update(User $user, Agenda $agenda): bool
    {
        return $user->is_active && in_array($user->role, ['super_admin', 'admin_cms']);
    }

    public function delete(User $user, Agenda $agenda): bool
    {
        return $user->is_active && in_array($user->role, ['super_admin', 'admin_cms']);
    }
}
