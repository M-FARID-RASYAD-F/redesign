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
        return $this->cover ? asset('storage/' . $this->cover) : asset('images/book-placeholder.png');
    }
}
