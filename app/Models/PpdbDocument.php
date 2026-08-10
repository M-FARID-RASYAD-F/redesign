<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PpdbDocument extends Model
{
    protected $fillable = [
        'registration_id',
        'doc_type',
        'file_path',
        'verification_status',
    ];

    public function registration()
    {
        return $this->belongsTo(PpdbRegistration::class, 'registration_id');
    }
}
