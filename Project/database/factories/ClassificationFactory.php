<?php

namespace Database\Factories;

use App\Models\Classification;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClassificationFactory extends Factory
{
    protected $model = Classification::class;

    public function definition(): array
    {
        return [
            'code' => fake()->unique()->numerify('###'),
            'name' => fake()->words(3, true),
            'description' => fake()->optional()->sentence(),
            'parent_code' => null,
            'level' => 1,
        ];
    }

    public function level(int $level): static
    {
        return $this->state(fn (array $attributes) => [
            'level' => $level,
        ]);
    }

    public function withParent(string $parentCode): static
    {
        return $this->state(fn (array $attributes) => [
            'parent_code' => $parentCode,
        ]);
    }
}
