<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use App\Models\OptionsHistory;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $question_id)
    {
        $question = Question::findOrFail($question_id);

        if ($question['active'] == true) {
            if ($question['question_type'] == 'open_ended') {
                $request->validate([
                    'user_text' => 'required|string|max:1023'
                ]);
                $question->answers()->create($request->all());
            } else {
                $options = $question->options()->get();
                $i = 1;
                foreach ($options as $option) {
                    if (isset($request['selected' . $i])) {
                        $option->optionsHistory()->increment('times_answered');
                    }
                    $i++;
                }
            }

            return redirect("/question/{$question_id}/answers");
        }

        return to_route('welcome')->with('message', ('Question is not active'));
    }

    /**
     * Display the specified resource.
     */
    public function show($question_id)
    {
        return view("answer.showAnswer", ['question_id' => $question_id]);
    }

    public function updateShow($question_id) {
        $question = Question::findOrFail($question_id);
        if($question->question_type == 'multiple_choice') {
            $options = $question->options()->with('optionsHistory')->get();
            $optionCounts = [];
            foreach ($options as $option) {
                $optionCounts[$option->option_text] = $option->optionsHistory->times_answered;
            }
            return response()->json($optionCounts);
        } else {
            $answerCounts = Answer::select('user_text', \DB::raw('count(*) as count'))
                ->withQuestionId($question_id)
                ->where('archived', false)
                ->groupBy('user_text')
                ->get()
                ->pluck('count', 'user_text')
                ->all();

            return response()->json($answerCounts);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Answer $answer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Answer $answer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Answer $answer)
    {
        //
    }

    public function comparison(Question $question)
    {
        $answers = Answer::where('question_id', $question->id)->where('archived', false)->get();
        if($question->question_type == 'open_ended') {
            $archivedAnswers = Answer::where('question_id', $question->id)->where('archived', true)->get();
        } else {
            $archivedAnswers = OptionsHistory::whereHas('option', function($query) use ($question) {
                $query->where('question_id', $question->id);
            })->where('archived', true)->get();
        }
        $question->load('options');
        return view('answer.compare', ['question' => $question, 'answers' => $answers, 'archivedAnswers' => $archivedAnswers]);
    }
}
