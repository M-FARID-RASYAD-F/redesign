<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = [
        'user_id',
        'module',
        'action',
        'description',
    ];

    // Only created_at timestamp is present
    const UPDATED_AT = null;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
