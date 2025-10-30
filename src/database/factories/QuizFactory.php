<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class QuizFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->word(),
            'description' => fake()->sentence(6),
            'owner_id' => 1,
            'active' => true,
        ];
    }
}
