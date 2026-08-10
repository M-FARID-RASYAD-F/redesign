<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherStaff extends Model
{
    /** @use HasFactory<\Database\Factories\TeacherStaffFactory> */
    use HasFactory;

    protected $table = 'teachers_staff';

    protected $fillable = [
        'name',
        'position',
        'subject',
        'photo',
        'nip',
        'status',
    ];
}
