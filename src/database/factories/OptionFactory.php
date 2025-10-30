<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class OptionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'question_id' => 1,
            'option_text' => fake()->word(),
            'correct' => true
        ];
    }
}
