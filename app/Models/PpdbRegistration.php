<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PpdbRegistration extends Model
{
    /** @use HasFactory<\Database\Factories\PpdbRegistrationFactory> */
    use HasFactory;

    protected $fillable = [
        'no_pendaftaran',
        'full_name',
        'gender',
        'birth_date',
        'address',
        'parent_name',
        'parent_phone',
        'jenjang',
        'major_choice',
        'status',
        'notes',
    ];

    protected function jenjangLabel(): Attribute
    {
        return Attribute::make(
            get: fn () => match (strtolower($this->jenjang ?? '')) {
                'sd' => 'Sekolah Dasar (SD)',
                'smp' => 'Sekolah Menengah Pertama (SMP)',
                'smk' => 'Sekolah Menengah Kejuruan (SMK)',
                default => strtoupper($this->jenjang ?? '-'),
            }
        );
    }

    protected function jenjangCode(): Attribute
    {
        return Attribute::make(
            get: fn () => strtoupper($this->jenjang ?? '-')
        );
    }

    protected function jenjangIcon(): Attribute
    {
        return Attribute::make(
            get: fn () => match (strtolower($this->jenjang ?? '')) {
                'sd' => '🎒',
                'smp' => '📚',
                'smk' => '💻',
                default => '🏫',
            }
        );
    }

    protected $casts = [
        'birth_date' => 'date',
    ];

    public function scopeStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeJenjang($query, string $jenjang)
    {
        return $query->where('jenjang', $jenjang);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(PpdbDocument::class, 'registration_id');
    }
}
