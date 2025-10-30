<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


class QuestionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'question' => fake()->sentence(6),
            'owner_id' => 1,
            'subject_id' => 1,
            'active' => true,
        ];
    }
}
