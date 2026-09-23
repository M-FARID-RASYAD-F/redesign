<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LibraryMember extends Model
{
    protected $fillable = ['full_name', 'member_code', 'phone', 'address', 'joined_at'];
    protected $casts = ['joined_at' => 'date'];

    public function loans()
    {
        return $this->hasMany(BookLoan::class, 'member_id');
    }

    protected static function booted(): void
    {
        static::creating(function (LibraryMember $member) {
            if (empty($member->joined_at)) {
                $member->joined_at = now();
            }
            if (empty($member->member_code)) {
                $year = date('Y');
                $count = static::whereYear('created_at', $year)->count() + 1;
                $code = 'ANG-' . $year . '-' . str_pad((string) $count, 4, '0', STR_PAD_LEFT);
                while (static::where('member_code', $code)->exists()) {
                    $count++;
                    $code = 'ANG-' . $year . '-' . str_pad((string) $count, 4, '0', STR_PAD_LEFT);
                }
                $member->member_code = $code;
            }
        });
    }
}
