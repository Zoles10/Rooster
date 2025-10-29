<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Subject;
use App\Models\Question;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    public function run()
    {
        $admin = User::where('email', 'admin@admin.sk')->first();
        $subject1 = Subject::where('subject', 'WEBTE2')->first();
        $subject2 = Subject::where('subject', 'VSA')->first();

        Question::create([
            'question' => 'What is Laravel?',
            'owner_id' => $admin->id,
            'subject_id' => $subject1->id,
            'active' => true,
        ]);

        Question::create([
            'question' => 'Which database does Laravel support?',
            'owner_id' => $admin->id,
            'subject_id' => $subject1->id,
            'active' => true,
        ]);

        Question::create([
            'question' => 'What is MVC?',
            'owner_id' => $admin->id,
            'subject_id' => $subject1->id,
            'active' => true,
        ]);

        Question::create([
            'question' => 'What is Blade in Laravel?',
            'owner_id' => $admin->id,
            'subject_id' => $subject1->id,
            'active' => true,
        ]);

        Question::create([
            'question' => 'What is Eloquent ORM?',
            'owner_id' => $admin->id,
            'subject_id' => $subject1->id,
            'active' => true,
        ]);

        Question::create([
            'question' => 'What is middleware in Laravel?',
            'owner_id' => $admin->id,
            'subject_id' => $subject2->id,
            'active' => true,
        ]);

        Question::create([
            'question' => 'What is Artisan?',
            'owner_id' => $admin->id,
            'subject_id' => $subject2->id,
            'active' => true,
        ]);

        Question::create([
            'question' => 'What is migration in Laravel?',
            'owner_id' => $admin->id,
            'subject_id' => $subject2->id,
            'active' => true,
        ]);
    }
}
