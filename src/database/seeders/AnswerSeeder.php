<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Answer;
use App\Models\Question;
use Illuminate\Database\Seeder;

class AnswerSeeder extends Seeder
{
    public function run()
    {
        $user1 = User::where('email', 'user1@imp.sk')->first();
        $user2 = User::where('email', 'user2@imp.sk')->first();
        $user3 = User::where('email', 'user3@imp.sk')->first();
        $questions = Question::all();

        /// user 1 answers
        Answer::create([
            'user_id' => $user1->id,
            'option_id' => $questions[0]->options()->where('option_text', 'PHP Framework')->first()->id,
            'correct' => true,
        ]);

        Answer::create([
            'user_id' => $user1->id,
            'option_id' => $questions[1]->options()->where('option_text', 'MySQL and PostgreSQL')->first()->id,
            'correct' => true,
        ]);

        Answer::create([
            'user_id' => $user1->id,
            'option_id' => $questions[2]->options()->where('option_text', 'Model View Controller')->first()->id,
            'correct' => true,
        ]);

        Answer::create([
            'user_id' => $user1->id,
            'option_id' => $questions[3]->options()->where('option_text', 'Templating Engine')->first()->id,
            'correct' => true,
        ]);

        Answer::create([
            'user_id' => $user1->id,
            'option_id' => $questions[4]->options()->where('option_text', 'Web Server')->first()->id,
            'correct' => false,
        ]);

        /// user 2 answers
        Answer::create([
            'user_id' => $user2->id,
            'option_id' => $questions[0]->options()->where('option_text', 'JavaScript Library')->first()->id,
            'correct' => false,
        ]);

        Answer::create([
            'user_id' => $user2->id,
            'option_id' => $questions[1]->options()->where('option_text', 'MySQL and PostgreSQL')->first()->id,
            'correct' => true,
        ]);

        Answer::create([
            'user_id' => $user2->id,
            'option_id' => $questions[2]->options()->where('option_text', 'Multiple Variable Code')->first()->id,
            'correct' => false,
        ]);

        Answer::create([
            'user_id' => $user2->id,
            'option_id' => $questions[3]->options()->where('option_text', 'Templating Engine')->first()->id,
            'correct' => true,
        ]);

        Answer::create([
            'user_id' => $user2->id,
            'option_id' => $questions[4]->options()->where('option_text', 'Database Abstraction Layer')->first()->id,
            'correct' => true,
        ]);

        /// user 3 answers
        Answer::create([
            'user_id' => $user3->id,
            'option_id' => $questions[0]->options()->where('option_text', 'PHP Framework')->first()->id,
            'correct' => true,
        ]);

        Answer::create([
            'user_id' => $user3->id,
            'option_id' => $questions[1]->options()->where('option_text', 'MySQL and PostgreSQL')->first()->id,
            'correct' => true,
        ]);

        Answer::create([
            'user_id' => $user3->id,
            'option_id' => $questions[2]->options()->where('option_text', 'Model View Controller')->first()->id,
            'correct' => true,
        ]);

        Answer::create([
            'user_id' => $user3->id,
            'option_id' => $questions[3]->options()->where('option_text', 'Database Tool')->first()->id,
            'correct' => false,
        ]);

        Answer::create([
            'user_id' => $user3->id,
            'option_id' => $questions[4]->options()->where('option_text', 'Database Abstraction Layer')->first()->id,
            'correct' => true,
        ]);
    }
}
