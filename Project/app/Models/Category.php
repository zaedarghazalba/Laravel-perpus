<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'slug',
        'description',
    ];

    // Relationships
    public function books()
    {
        return $this->hasMany(Book::class);
    }

    public function ebooks()
    {
        return $this->hasMany(Ebook::class);
    }
}
