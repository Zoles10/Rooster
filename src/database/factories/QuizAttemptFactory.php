<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class QuizAttemptFactory extends Factory
{
    public function definition(): array
    {
        return [
            'quiz_id' => 1,
            'user_id' => 1,
        ];
    }
}
