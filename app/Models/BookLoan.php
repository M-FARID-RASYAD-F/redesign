<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookLoan extends Model
{
    protected $fillable = [
        'loan_code', 'member_id', 'book_id', 'borrowed_at',
        'due_at', 'returned_at', 'status', 'notes',
    ];

    protected $casts = [
        'borrowed_at' => 'date',
        'due_at'      => 'date',
        'returned_at' => 'date',
    ];

    public function member()
    {
        return $this->belongsTo(LibraryMember::class, 'member_id');
    }

    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id');
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'diajukan'     => 'Menunggu Verifikasi',
            'dipinjam'     => 'Sedang Dipinjam',
            'dikembalikan' => 'Sudah Dikembalikan',
            'terlambat'    => 'Terlambat',
            default        => ucfirst($this->status),
        };
    }

    protected static function booted(): void
    {
        static::creating(function (BookLoan $loan) {
            if (empty($loan->loan_code)) {
                $year = date('Y');
                do {
                    $randomPart = str_pad((string) random_int(1000, 9999), 4, '0', STR_PAD_LEFT);
                    $code = 'PINJAM-' . $year . '-' . $randomPart;
                } while (static::where('loan_code', $code)->exists());

                $loan->loan_code = $code;
            }
        });
    }
}
