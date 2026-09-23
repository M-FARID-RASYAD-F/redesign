<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Book extends Model
{
    use HasFactory;

    protected $table = 'books';

    protected $fillable = [
        'category_id',
        'rack_id',
        'title',
        'slug',
        'isbn',
        'author',
        'publisher',
        'publication_year',
        'pages',
        'stock',
        'available_stock',
        'cover_image',
        'description',
        'status',
    ];

    protected $casts = [
        'publication_year' => 'integer',
        'pages' => 'integer',
        'stock' => 'integer',
        'available_stock' => 'integer',
    ];

    /**
     * Relasi ke Kategori: Book belongsTo Category
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * Relasi ke Rak: Book belongsTo Rack
     */
    public function rack(): BelongsTo
    {
        return $this->belongsTo(Rack::class, 'rack_id');
    }

    /**
     * Scope untuk pencarian buku (judul, penulis, ISBN, penerbit)
     */
    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        if (blank($term)) {
            return $query;
        }

        return $query->where(function (Builder $q) use ($term) {
            $q->where('title', 'like', "%{$term}%")
              ->orWhere('author', 'like', "%{$term}%")
              ->orWhere('isbn', 'like', "%{$term}%")
              ->orWhere('publisher', 'like', "%{$term}%");
        });
    }

    /**
     * Scope filter berdasarkan slug kategori
     */
    public function scopeFilterByCategory(Builder $query, ?string $categorySlug): Builder
    {
        if (blank($categorySlug) || $categorySlug === 'all') {
            return $query;
        }

        return $query->whereHas('category', function (Builder $q) use ($categorySlug) {
            $q->where('slug', $categorySlug);
        });
    }

    /**
     * Scope filter berdasarkan rak
     */
    public function scopeFilterByRack(Builder $query, $rackId): Builder
    {
        if (blank($rackId) || $rackId === 'all') {
            return $query;
        }

        return $query->where('rack_id', $rackId);
    }

    /**
     * Scope hanya buku yang stoknya tersedia untuk dipinjam
     */
    public function scopeAvailable(Builder $query): Builder
    {
        return $query->where('available_stock', '>', 0)
                     ->where('status', 'tersedia');
    }

    /**
     * Accessor URL cover image
     */
    public function getCoverUrlAttribute(): string
    {
        if (!empty($this->cover_image)) {
            if (str_starts_with($this->cover_image, 'http://') || str_starts_with($this->cover_image, 'https://')) {
                return $this->cover_image;
            }
            return asset($this->cover_image);
        }

        return asset('images/default-book-cover.svg');
    }
}
