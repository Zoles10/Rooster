<?php

namespace Database\Seeders;

use App\Models\QuizAttempt;
use App\Models\User;
use App\Models\Quiz;
use Illuminate\Database\Seeder;

class QuizAttemptSeeder extends Seeder
{
    public function run()
    {
        $user1 = User::where('email', 'user1@imp.sk')->first();
        $user2 = User::where('email', 'user2@imp.sk')->first();
        $user3 = User::where('email', 'user3@imp.sk')->first();
        $quiz = Quiz::all()->first();

        QuizAttempt::factory()->create([
            'quiz_id' => $quiz->id,
            'user_id' => $user1->id,
        ]);

        QuizAttempt::factory()->create([
            'quiz_id' => $quiz->id,
            'user_id' => $user2->id,
        ]);

        QuizAttempt::factory()->create([
            'quiz_id' => $quiz->id,
            'user_id' => $user3->id,
        ]);
    }
}
