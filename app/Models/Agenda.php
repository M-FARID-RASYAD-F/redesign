<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    /** @use HasFactory<\Database\Factories\AgendaFactory> */
    use HasFactory;

    protected $table = 'agenda';

    protected $fillable = [
        'title',
        'date',
        'location',
        'description',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
        ];
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
