<?php

namespace Database\Seeders;

use App\Models\Quiz;
use App\Models\User;
use App\Models\Question;
use Illuminate\Database\Seeder;

class QuizSeeder extends Seeder
{
    public function run()
    {
        $admin = User::where('email', 'admin@admin.sk')->first();
        $questions = Question::all();

        $quiz = Quiz::create([
            'title' => 'Laravel Basics Quiz',
            'description' => 'Test your knowledge of Laravel fundamentals and core concepts',
            'owner_id' => $admin->id,
            'active' => true,
        ]);

        for ($i = 0; $i < 5; $i++) {
            $questions[$i]->quiz_id = $quiz->id;
            $questions[$i]->save();
        }

    }
}
