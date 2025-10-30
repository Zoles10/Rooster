<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AnswerFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => 1,
            'option_id' => 1,
            'correct' => true,
        ];
    }
}
