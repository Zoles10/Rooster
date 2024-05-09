<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
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
        $subjects = Subject::all();
        return view('question.create', ['subjects' => $subjects]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $question = new Question;
        $validatedData = $request->validate([
            'question' => 'required|string|max:1023',
            'question_type' => 'required|string|in:multiple_choice,open_ended',
        ]);
        $question->question = $validatedData['question'];
        $question->question_type = $validatedData['question_type'];
        $question->owner_id = Auth::id();

        if($request->input('subject') != 0) {
            $question->subject()->associate($request->input('subject'));
        } else {
            $subject = Subject::firstOrCreate(['subject' => $request->input('other_subject')]);
            $question->subject()->associate($subject);
        }

        if ($validatedData['question_type'] === 'multiple_choice') {
            $i = 1;
            foreach ($request->all() as $key => $value) {
                if (str_starts_with($key, 'option')) {
                    $option = $request->input('option' . $i);
                    $correct = $request->input('isCorrect' . $i);
                    $correct = isset($correct) ? true : false;
                    if ($option) {
                        $question->options()->create(['option_text' => $option, 'correct' => $correct]);
                    }
                }
                $i++;
            }
        }
        $question->save();
        return response()->json(['message' => 'Question created successfully'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Question $question)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Question $question)
    {
        return view('question.edit', compact('question'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Question $question)
    {
        $validatedData = $request->validate([
            'question' => 'sometimes|required|string|max:1023',
            'question_type' => 'sometimes|required|string|in:multiple_choice,open_ended',
        ]);

        $question->update($validatedData);

        return redirect()->route('dashboard', $question);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Question $question)
    {
        //
    }
}
