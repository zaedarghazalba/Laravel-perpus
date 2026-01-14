<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    protected $model = Book::class;

    public function definition(): array
    {
        return [
            'title' => fake()->sentence(4),
            'author' => fake()->name(),
            'publisher' => fake()->company(),
            'publication_year' => fake()->numberBetween(1990, date('Y')),
            'isbn' => fake()->optional(0.7)->isbn13(),
            'barcode' => fake()->optional(0.8)->numerify('BC####'),
            'classification_code' => null,
            'call_number' => fake()->optional(0.5)->bothify('??-###'),
            'shelf_location' => null,
            'quantity' => fake()->numberBetween(1, 20),
            'available_quantity' => function (array $attributes) {
                return $attributes['quantity'];
            },
            'description' => fake()->optional(0.6)->paragraph(),
        ];
    }

    public function withClassification(string $code): static
    {
        return $this->state(fn (array $attributes) => [
            'classification_code' => $code,
            'shelf_location' => Book::generateShelfLocation($code),
        ]);
    }

    public function unavailable(): static
    {
        return $this->state(fn (array $attributes) => [
            'available_quantity' => 0,
        ]);
    }
}
