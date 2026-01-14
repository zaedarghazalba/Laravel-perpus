<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'student_id',
        'email',
        'phone',
        'address',
        'join_date',
    ];

    protected $casts = [
        'join_date' => 'date',
    ];

    // Relationships
    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }
}
