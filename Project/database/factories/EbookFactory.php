<?php

namespace Database\Factories;

use App\Models\Ebook;
use Illuminate\Database\Eloquent\Factories\Factory;

class EbookFactory extends Factory
{
    protected $model = Ebook::class;

    public function definition(): array
    {
        return [
            'title' => fake()->sentence(4),
            'author' => fake()->name(),
            'publisher' => fake()->optional()->company(),
            'publication_year' => fake()->optional()->numberBetween(1990, date('Y')),
            'isbn' => fake()->optional()->isbn13(),
            'classification_code' => null,
            'file_path' => 'uploads/ebooks/sample.pdf',
            'file_size' => fake()->numberBetween(100000, 10000000),
            'cover_image' => null,
            'description' => fake()->optional()->paragraph(),
            'is_published' => true,
            'view_count' => 0,
            'download_count' => 0,
        ];
    }

    public function unpublished(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_published' => false,
        ]);
    }
}
