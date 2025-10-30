<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            SubjectSeeder::class,
            QuestionSeeder::class,
            OptionSeeder::class,
            QuizSeeder::class,
            AnswerSeeder::class,
            QuizAttemptSeeder::class,
        ]);
    }
}
