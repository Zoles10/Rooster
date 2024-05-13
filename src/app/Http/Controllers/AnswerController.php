<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
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
                        $option->optionsHistory->increment('times_answered');
                    }
                    $i++;
                }
            }

            return view("answer.showAnswer");
        }

        return to_route('welcome')->with('message', ('Question is not active'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Answer $answer)
    {
        return view("answer.showAnswer");
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
}
