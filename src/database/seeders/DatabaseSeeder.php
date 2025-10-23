<?php

namespace Database\Seeders;

use App\Models\Subject;
use App\Models\User;
use App\Models\Question;
use App\Models\Option;
use App\Models\Answer;
use App\Models\Quiz;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Dummy Users
        User::factory()->create([
            "name" => "admin",
            "email" => "admin@admin.sk",
            "admin" => 1,
            "password" => \Illuminate\Support\Facades\Hash::make('admin'),
        ]);

        User::factory()->create([
            "name" => "user1",
            "email" => "user1@imp.sk",
            "admin" => 0,
            "password" => \Illuminate\Support\Facades\Hash::make('12345678'),
        ]);

        User::factory()->create([
            "name" => "user2",
            "email" => "user2@imp.sk",
            "admin" => 0,
            "password" => \Illuminate\Support\Facades\Hash::make('12345678'),
        ]);

        User::factory()->create([
            "name" => "user3",
            "email" => "user3@imp.sk",
            "admin" => 0,
            "password" => \Illuminate\Support\Facades\Hash::make('12345678'),
        ]);

        User::factory()->create([
            "name" => "user4",
            "email" => "user4@imp.sk",
            "admin" => 0,
            "password" => \Illuminate\Support\Facades\Hash::make('12345678'),
        ]);

        // Subjects
        Subject::factory()->create([
            "subject" => "WEBTE2",
        ]);

        Subject::factory()->create([
            "subject" => "VSA",
        ]);

        Subject::factory()->create([
            "subject" => "UHD",
        ]);

        // Get admin user and subjects
        $admin = User::where('email', 'admin@admin.sk')->first();
        $subject1 = Subject::where('subject', 'WEBTE2')->first();
        $subject2 = Subject::where('subject', 'VSA')->first();

        // Create 8 dummy questions for admin
        $questions = [];

        // Question 1
        $q1 = Question::create([
            'question' => 'What is Laravel?',
            'owner_id' => $admin->id,
            'subject_id' => $subject1->id,
            'active' => true,
        ]);
        Option::create(['question_id' => $q1->id, 'option_text' => 'PHP Framework', 'correct' => true]);
        Option::create(['question_id' => $q1->id, 'option_text' => 'JavaScript Library', 'correct' => false]);
        $questions[] = $q1;

        // Question 2
        $q2 = Question::create([
            'question' => 'Which database does Laravel support?',
            'owner_id' => $admin->id,
            'subject_id' => $subject1->id,
            'active' => true,
        ]);
        Option::create(['question_id' => $q2->id, 'option_text' => 'MySQL and PostgreSQL', 'correct' => true]);
        Option::create(['question_id' => $q2->id, 'option_text' => 'Only MongoDB', 'correct' => false]);
        $questions[] = $q2;

        // Question 3
        $q3 = Question::create([
            'question' => 'What is MVC?',
            'owner_id' => $admin->id,
            'subject_id' => $subject1->id,
            'active' => true,
        ]);
        Option::create(['question_id' => $q3->id, 'option_text' => 'Model View Controller', 'correct' => true]);
        Option::create(['question_id' => $q3->id, 'option_text' => 'Multiple Variable Code', 'correct' => false]);
        $questions[] = $q3;

        // Question 4
        $q4 = Question::create([
            'question' => 'What is Blade in Laravel?',
            'owner_id' => $admin->id,
            'subject_id' => $subject1->id,
            'active' => true,
        ]);
        Option::create(['question_id' => $q4->id, 'option_text' => 'Templating Engine', 'correct' => true]);
        Option::create(['question_id' => $q4->id, 'option_text' => 'Database Tool', 'correct' => false]);
        $questions[] = $q4;

        // Question 5
        $q5 = Question::create([
            'question' => 'What is Eloquent ORM?',
            'owner_id' => $admin->id,
            'subject_id' => $subject1->id,
            'active' => true,
        ]);
        Option::create(['question_id' => $q5->id, 'option_text' => 'Database Abstraction Layer', 'correct' => true]);
        Option::create(['question_id' => $q5->id, 'option_text' => 'Web Server', 'correct' => false]);
        $questions[] = $q5;

        // Question 6
        $q6 = Question::create([
            'question' => 'What is middleware in Laravel?',
            'owner_id' => $admin->id,
            'subject_id' => $subject2->id,
            'active' => true,
        ]);
        Option::create(['question_id' => $q6->id, 'option_text' => 'HTTP Request Filter', 'correct' => true]);
        Option::create(['question_id' => $q6->id, 'option_text' => 'Frontend Component', 'correct' => false]);
        $questions[] = $q6;

        // Question 7
        $q7 = Question::create([
            'question' => 'What is Artisan?',
            'owner_id' => $admin->id,
            'subject_id' => $subject2->id,
            'active' => true,
        ]);
        Option::create(['question_id' => $q7->id, 'option_text' => 'Command Line Interface', 'correct' => true]);
        Option::create(['question_id' => $q7->id, 'option_text' => 'CSS Framework', 'correct' => false]);
        $questions[] = $q7;

        // Question 8
        $q8 = Question::create([
            'question' => 'What is migration in Laravel?',
            'owner_id' => $admin->id,
            'subject_id' => $subject2->id,
            'active' => true,
        ]);
        Option::create(['question_id' => $q8->id, 'option_text' => 'Database Version Control', 'correct' => true]);
        Option::create(['question_id' => $q8->id, 'option_text' => 'User Authentication', 'correct' => false]);
        $questions[] = $q8;

        // Create a quiz with first 5 questions
        $quiz = Quiz::create([
            'title' => 'Laravel Basics Quiz',
            'description' => 'Test your knowledge of Laravel fundamentals and core concepts',
            'owner_id' => $admin->id,
            'active' => true,
        ]);

        // Assign first 5 questions to the quiz
        for ($i = 0; $i < 5; $i++) {
            $questions[$i]->quiz_id = $quiz->id;
            $questions[$i]->save();
        }

        // Get users for answering the quiz
        $user1 = User::where('email', 'user1@imp.sk')->first();
        $user2 = User::where('email', 'user2@imp.sk')->first();
        $user3 = User::where('email', 'user3@imp.sk')->first();

        // Create answers for user1 (mostly correct answers)
        // Question 1: What is Laravel? - Correct: PHP Framework
        Answer::create([
            'user_id' => $user1->id,
            'option_id' => $questions[0]->options()->where('option_text', 'PHP Framework')->first()->id,
            'correct' => true,
        ]);

        // Question 2: Which database does Laravel support? - Correct: MySQL and PostgreSQL
        Answer::create([
            'user_id' => $user1->id,
            'option_id' => $questions[1]->options()->where('option_text', 'MySQL and PostgreSQL')->first()->id,
            'correct' => true,
        ]);

        // Question 3: What is MVC? - Correct: Model View Controller
        Answer::create([
            'user_id' => $user1->id,
            'option_id' => $questions[2]->options()->where('option_text', 'Model View Controller')->first()->id,
            'correct' => true,
        ]);

        // Question 4: What is Blade in Laravel? - Correct: Templating Engine
        Answer::create([
            'user_id' => $user1->id,
            'option_id' => $questions[3]->options()->where('option_text', 'Templating Engine')->first()->id,
            'correct' => true,
        ]);

        // Question 5: What is Eloquent ORM? - Wrong answer for variety
        Answer::create([
            'user_id' => $user1->id,
            'option_id' => $questions[4]->options()->where('option_text', 'Web Server')->first()->id,
            'correct' => false,
        ]);

        // Create answers for user2 (mix of correct and incorrect)
        // Question 1: What is Laravel? - Wrong
        Answer::create([
            'user_id' => $user2->id,
            'option_id' => $questions[0]->options()->where('option_text', 'JavaScript Library')->first()->id,
            'correct' => false,
        ]);

        // Question 2: Which database does Laravel support? - Correct
        Answer::create([
            'user_id' => $user2->id,
            'option_id' => $questions[1]->options()->where('option_text', 'MySQL and PostgreSQL')->first()->id,
            'correct' => true,
        ]);

        // Question 3: What is MVC? - Wrong
        Answer::create([
            'user_id' => $user2->id,
            'option_id' => $questions[2]->options()->where('option_text', 'Multiple Variable Code')->first()->id,
            'correct' => false,
        ]);

        // Question 4: What is Blade in Laravel? - Correct
        Answer::create([
            'user_id' => $user2->id,
            'option_id' => $questions[3]->options()->where('option_text', 'Templating Engine')->first()->id,
            'correct' => true,
        ]);

        // Question 5: What is Eloquent ORM? - Correct
        Answer::create([
            'user_id' => $user2->id,
            'option_id' => $questions[4]->options()->where('option_text', 'Database Abstraction Layer')->first()->id,
            'correct' => true,
        ]);

        // Create answers for user3 (some questions answered, some skipped)
        // Question 1: What is Laravel? - Correct
        Answer::create([
            'user_id' => $user3->id,
            'option_id' => $questions[0]->options()->where('option_text', 'PHP Framework')->first()->id,
            'correct' => true,
        ]);

        // Question 2: Which database does Laravel support? - Correct
        Answer::create([
            'user_id' => $user3->id,
            'option_id' => $questions[1]->options()->where('option_text', 'MySQL and PostgreSQL')->first()->id,
            'correct' => true,
        ]);

        // Question 3: What is MVC? - Correct
        Answer::create([
            'user_id' => $user3->id,
            'option_id' => $questions[2]->options()->where('option_text', 'Model View Controller')->first()->id,
            'correct' => true,
        ]);

        // Question 4: What is Blade in Laravel? - Wrong
        Answer::create([
            'user_id' => $user3->id,
            'option_id' => $questions[3]->options()->where('option_text', 'Database Tool')->first()->id,
            'correct' => false,
        ]);

        // Question 5: What is Eloquent ORM? - Correct
        Answer::create([
            'user_id' => $user3->id,
            'option_id' => $questions[4]->options()->where('option_text', 'Database Abstraction Layer')->first()->id,
            'correct' => true,
        ]);

    }
}
