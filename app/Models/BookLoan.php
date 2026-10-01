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
            'disetujui'    => 'Disetujui (Siap Diambil)',
            'dipinjam'     => 'Sedang Dipinjam',
            'dikembalikan' => 'Sudah Dikembalikan',
            'terlambat'    => 'Terlambat',
            'ditolak'      => 'Pengajuan Ditolak',
            default        => ucfirst($this->status),
        };
    }
}
