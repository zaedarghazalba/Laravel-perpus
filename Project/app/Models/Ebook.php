<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ebook extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'author',
        'publisher',
        'isbn',
        'barcode',
        'classification_code',
        'call_number',
        'publication_year',
        'category_id',
        'description',
        'cover_image',
        'file_path',
        'file_size',
        'download_count',
        'view_count',
        'is_published',
    ];

    protected $casts = [
        'publication_year' => 'integer',
        'file_size' => 'integer',
        'download_count' => 'integer',
        'view_count' => 'integer',
        'is_published' => 'boolean',
    ];

    // Relationships
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function ebookViews()
    {
        return $this->hasMany(EbookView::class);
    }

    public function classification()
    {
        return $this->belongsTo(Classification::class, 'classification_code', 'code');
    }
}
