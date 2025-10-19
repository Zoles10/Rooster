<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnswerController extends Controller
{
    public function index()
    {
    }

    public function create()
    {
    }

    public function store(Request $request, $question_id)
    {
        $question = Question::findOrFail($question_id);
        $options = $question->options()->get();
        $selectedOption = null;

        $i = 1;
        foreach ($options as $option) {
            if (isset($request['selected'.$i])) {
                $selectedOption = $option;
            }
            $i++;
        }

        $answer = $selectedOption->answers()->create([
            'user_id' => Auth::id(),
            'correct' => $selectedOption->correct,
        ]);

        return to_route('welcome')->with('message', 'Answer submitted');
    }

    public function show($option_id)
    {
        return view("answer.showAnswer", ['question_id' => $option_id]);
    }

    public function updateShow($question_id)
    {
        $question = Question::findOrFail($question_id);

        $answers = Answer::whereHas('option', function ($query) use ($question_id) {
            $query->where('question_id', $question_id);
        })
            ->with(['user:id,name', 'option:id,option_text,correct'])
            ->get()
            ->map(function ($answer) {
                return [
                    'user_name' => $answer->user->name,
                    'selected_option' => $answer->option->option_text,
                    'correct' => $answer->correct,
                ];
            });

        return response()->json($answers);
    }

    public function edit(Answer $answer)
    {
    }

    public function update(Request $request, Answer $answer)
    {
    }

    public function destroy(Answer $answer)
    {
    }

    public function comparison(Question $question)
    {
        return view("answer.compare");
    }

    public function export(Question $question)
    {
        $answers = Answer::whereHas('option', function ($query) use ($question) {
            $query->where('question_id', $question->id);
        })
            ->with(['user:id,name', 'option:id,option_text,correct'])
            ->get()
            ->map(function ($answer) {
                return [
                    'user_name' => $answer->user->name,
                    'selected_option' => $answer->option->option_text,
                    'correct' => $answer->correct ? 'Yes' : 'No',
                ];
            });

        $tempFile = tempnam(sys_get_temp_dir(), 'question_export_');
        $csvFile = fopen($tempFile, 'w');

        fputcsv($csvFile, ['Question:', $question->question]);
        fputcsv($csvFile, []);
        fputcsv($csvFile, ['User Name', 'Selected Option', 'Correct']);

        foreach ($answers as $answer) {
            fputcsv($csvFile, [
                $answer['user_name'],
                $answer['selected_option'],
                $answer['correct'],
            ]);
        }

        fclose($csvFile);
        $fileName = 'question-'.$question->id.'-answers-export.csv';
        return response()->download($tempFile, $fileName)->deleteFileAfterSend(true);
    }
}
