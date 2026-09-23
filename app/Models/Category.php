<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
    ];

    /**
     * Relasi ke buku: Category hasMany Book
     */
    public function books(): HasMany
    {
        return $this->hasMany(Book::class, 'category_id');
    }

    /**
     * Mengembalikan representasi SVG icon standar yang seragam dengan style website.
     */
    public function getIconSvgAttribute(): string
    {
        return view('components.category-icon', [
            'icon' => $this->icon,
            'category' => $this,
            'size' => 15,
        ])->render();
    }
}
