<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


#[Fillable(['name', 'email', 'password', 'role', 'is_active'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Determine if the user can access the Filament panel.
     */
    public function canAccessPanel(Panel $panel): bool
    {
        return $this->is_active && in_array($this->role, [
            'super_admin',
            'admin_cms',
            'admin_ppdb',
            'editor_akademik'
        ]);
    }

    // Role helper methods
    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    public function isAdminCms(): bool
    {
        return $this->role === 'admin_cms';
    }

    public function isAdminPpdb(): bool
    {
        return $this->role === 'admin_ppdb';
    }

    public function isEditorAkademik(): bool
    {
        return $this->role === 'editor_akademik';
    }

    public function hasRole(string|array $roles): bool
    {
        if (is_array($roles)) {
            return in_array($this->role, $roles);
        }
        return $this->role === $roles;
    }

    /**
     * RBAC Matrix (Section 3.4) Permissions
     */
    // Hak kelola pengguna admin (Hanya Super Admin)
    public function canManageUsers(): bool
    {
        return $this->isSuperAdmin();
    }

    // Hak kelola berita & galeri (Super Admin & Admin CMS)
    public function canManageCms(): bool
    {
        return in_array($this->role, ['super_admin', 'admin_cms']);
    }

    // Hak kelola data guru, staf & jurusan (Super Admin, Admin CMS, Editor Akademik)
    public function canManageAcademic(): bool
    {
        return in_array($this->role, ['super_admin', 'admin_cms', 'editor_akademik']);
    }

    // Hak kelola pengumuman & agenda (Super Admin & Admin CMS)
    public function canManageAnnouncements(): bool
    {
        return in_array($this->role, ['super_admin', 'admin_cms']);
    }

    // Hak kelola / aksi verifikasi & ubah status PPDB (Super Admin & Admin PPDB)
    public function canManagePpdb(): bool
    {
        return in_array($this->role, ['super_admin', 'admin_ppdb']);
    }

    // Relationships
    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }

    public function news()
    {
        return $this->hasMany(News::class, 'author_id');
    }

    public function galleries()
    {
        return $this->hasMany(Gallery::class, 'uploaded_by');
    }

    public function announcements()
    {
        return $this->hasMany(Announcement::class, 'created_by');
    }

    public function agendas()
    {
        return $this->hasMany(Agenda::class, 'created_by');
    }
}
