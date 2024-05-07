<?php

namespace App\Http\Controllers;

use App\Models\Question;
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $question = new Question;
        $validatedData = $request->validate([
            'question_text' => 'required|string|max:1023',
            'type' => 'required|string|in:multiple_choice,open_ended',
        ]);
        $question->question_text = $validatedData['question_text'];
        $question->type = $validatedData['type'];
        $question->owner_id = Auth::id();
        $question->subject_id = $request->input('subject_id');
        $question->poll_id = null;

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
            'question_text' => 'sometimes|required|string|max:1023',
            'type' => 'sometimes|required|string|in:multiple_choice,open_ended',
            'poll_id' => 'sometimes|required|integer|exists:polls,id',
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
