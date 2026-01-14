<?php

namespace Database\Factories;

use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

class MemberFactory extends Factory
{
    protected $model = Member::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'student_id' => fake()->unique()->numerify('STU#####'),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->optional(0.7)->phoneNumber(),
            'address' => fake()->optional(0.6)->address(),
            'join_date' => now(),
        ];
    }
}
