<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EbookView extends Model
{
    protected $fillable = [
        'ebook_id',
        'ip_address',
        'viewed_at',
    ];

    protected $casts = [
        'viewed_at' => 'datetime',
    ];

    // Relationships
    public function ebook()
    {
        return $this->belongsTo(Ebook::class);
    }
}
