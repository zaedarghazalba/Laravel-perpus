<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classification extends Model
{
    use HasFactory;
    protected $fillable = [
        'code',
        'name',
        'description',
        'parent_code',
        'level',
    ];

    protected $casts = [
        'level' => 'integer',
    ];

    // Relationship: Parent classification
    public function parent()
    {
        return $this->belongsTo(Classification::class, 'parent_code', 'code');
    }

    // Relationship: Children classifications
    public function children()
    {
        return $this->hasMany(Classification::class, 'parent_code', 'code');
    }

    // Relationship: Books using this classification
    public function books()
    {
        return $this->hasMany(Book::class, 'classification_code', 'code');
    }

    // Relationship: Ebooks using this classification
    public function ebooks()
    {
        return $this->hasMany(Ebook::class, 'classification_code', 'code');
    }

    // Scope: Get main classifications (level 1)
    public function scopeMainClassifications($query)
    {
        return $query->where('level', 1)->orderBy('code');
    }

    // Scope: Get by level
    public function scopeLevel($query, $level)
    {
        return $query->where('level', $level)->orderBy('code');
    }
}
