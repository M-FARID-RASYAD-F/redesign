<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'category_id', 'title', 'isbn', 'author', 'publisher', 'year',
        'stock', 'available', 'cover', 'synopsis', 'rack_location',
    ];

    protected $casts = [
        'year'      => 'integer',
        'stock'     => 'integer',
        'available' => 'integer',
    ];

    public function category()
    {
        return $this->belongsTo(BookCategory::class, 'category_id');
    }

    public function loans()
    {
        return $this->hasMany(BookLoan::class, 'book_id');
    }

    public function getCoverUrlAttribute(): string
    {
        if (empty($this->cover)) {
            return asset('images/book-placeholder.svg');
        }

        if (str_starts_with($this->cover, 'http://') || str_starts_with($this->cover, 'https://')) {
            return $this->cover;
        }

        if (str_starts_with($this->cover, 'images/')) {
            return asset($this->cover);
        }

        return asset('storage/' . $this->cover);
    }
}
