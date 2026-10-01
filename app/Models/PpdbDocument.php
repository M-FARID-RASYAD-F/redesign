<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PpdbDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'registration_id',
        'doc_type',
        'file_path',
        'verification_status',
    ];

    public function registration(): BelongsTo
    {
        return $this->belongsTo(PpdbRegistration::class, 'registration_id');
    }

    public function scopeVerified($query)
    {
        return $query->where('verification_status', 'valid');
    }

    public function scopeUnverified($query)
    {
        return $query->where('verification_status', 'belum_diverifikasi');
    }
}
