<?php

namespace App\Models;

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
        'major_choice',
        'status',
        'notes',
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    protected static function booted(): void
    {
        static::creating(function (PpdbRegistration $registration) {
            if (empty($registration->no_pendaftaran)) {
                $year = date('Y');
                $count = static::whereYear('created_at', $year)->count() + 1;
                $noPendaftaran = 'PPDB-' . $year . '-' . str_pad((string) $count, 4, '0', STR_PAD_LEFT);

                while (static::where('no_pendaftaran', $noPendaftaran)->exists()) {
                    $count++;
                    $noPendaftaran = 'PPDB-' . $year . '-' . str_pad((string) $count, 4, '0', STR_PAD_LEFT);
                }

                $registration->no_pendaftaran = $noPendaftaran;
            }
        });
    }

    public function documents(): HasMany
    {
        return $this->hasMany(PpdbDocument::class, 'registration_id');
    }
}
