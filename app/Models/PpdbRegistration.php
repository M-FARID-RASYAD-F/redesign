<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
        ];
    }

    public function documents()
    {
        return $this->hasMany(PpdbDocument::class, 'registration_id');
    }
}
