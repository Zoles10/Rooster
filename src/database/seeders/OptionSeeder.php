<?php

namespace Database\Seeders;

use App\Models\Question;
use App\Models\Option;
use Illuminate\Database\Seeder;

class OptionSeeder extends Seeder
{
    public function run()
    {
        $questions = Question::all();

        /// Question 1
        Option::factory()->create([
            'question_id' => $questions[0]->id,
            'option_text' => 'PHP Framework',
            'correct' => true
        ]);

        Option::factory()->create([
            'question_id' => $questions[0]->id,
            'option_text' => 'JavaScript Library',
            'correct' => false
        ]);

        /// Question 3
        Option::factory()->create([
            'question_id' => $questions[1]->id,
            'option_text' => 'MySQL and PostgreSQL',
            'correct' => true
        ]);

        Option::factory()->create([
            'question_id' => $questions[1]->id,
            'option_text' => 'Only MongoDB',
            'correct' => false
        ]);

        /// Question 4
        Option::factory()->create([
            'question_id' => $questions[2]->id,
            'option_text' => 'Model View Controller',
            'correct' => true
        ]);

        Option::factory()->create([
            'question_id' => $questions[2]->id,
            'option_text' => 'Multiple Variable Code',
            'correct' => false
        ]);

        /// Question 5
        Option::factory()->create([
            'question_id' => $questions[3]->id,
            'option_text' => 'Templating Engine',
            'correct' => true
        ]);

        Option::factory()->create([
            'question_id' => $questions[3]->id,
            'option_text' => 'Database Tool',
            'correct' => false
        ]);

        /// Question 7
        Option::factory()->create([
            'question_id' => $questions[4]->id,
            'option_text' => 'Database Abstraction Layer',
            'correct' => true
        ]);

        Option::factory()->create([
            'question_id' => $questions[4]->id,
            'option_text' => 'Web Server',
            'correct' => false
        ]);

        /// Question 6
        Option::factory()->create([
            'question_id' => $questions[5]->id,
            'option_text' => 'HTTP Request Filter',
            'correct' => true
        ]);

        Option::factory()->create([
            'question_id' => $questions[5]->id,
            'option_text' => 'Frontend Component',
            'correct' => false
        ]);

        /// Question 6
        Option::factory()->create([
            'question_id' => $questions[6]->id,
            'option_text' => 'Command Line Interface',
            'correct' => true
        ]);

        Option::factory()->create([
            'question_id' => $questions[6]->id,
            'option_text' => 'CSS Framework',
            'correct' => false
        ]);

        /// Question 6
        Option::factory()->create([
            'question_id' => $questions[7]->id,
            'option_text' => 'Database Version Control',
            'correct' => true
        ]);

        Option::factory()->create([
            'question_id' => $questions[7]->id,
            'option_text' => 'User Authentication',
            'correct' => false
        ]);
    }
}
