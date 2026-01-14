<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'author',
        'publisher',
        'publication_year',
        'isbn',
        'barcode',
        'classification_code',
        'call_number',
        'shelf_location',
        'quantity',
        'available_quantity',
        'category_id',
        'cover_image',
        'description',
    ];

    protected $casts = [
        'publication_year' => 'integer',
        'quantity' => 'integer',
        'available_quantity' => 'integer',
    ];

    // Relationships
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }

    public function classification()
    {
        return $this->belongsTo(Classification::class, 'classification_code', 'code');
    }

    /**
     * Generate shelf location based on classification code
     */
    public static function generateShelfLocation($classificationCode)
    {
        if (empty($classificationCode)) {
            return null;
        }

        // Extract main class (first digit/digits before decimal)
        $mainClass = (int)$classificationCode;

        // Determine rack based on Dewey Decimal Classification
        $rackMap = [
            0 => 'Rak A', // 000-099: Computer science, information & general works
            1 => 'Rak B', // 100-199: Philosophy & psychology
            2 => 'Rak C', // 200-299: Religion
            3 => 'Rak D', // 300-399: Social sciences
            4 => 'Rak E', // 400-499: Language
            5 => 'Rak F', // 500-599: Science
            6 => 'Rak G', // 600-699: Technology
            7 => 'Rak H', // 700-799: Arts & recreation
            8 => 'Rak I', // 800-899: Literature
            9 => 'Rak J', // 900-999: History & geography
        ];

        $rackLetter = $rackMap[floor($mainClass / 100)] ?? 'Rak A';

        // Determine shelf number based on tens digit
        $shelfNumber = floor(($mainClass % 100) / 10) + 1;

        return $rackLetter . '-' . $shelfNumber;
    }
}
