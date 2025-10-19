<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    public function getAllByUserId(string $id)
    {
        $questions = Question::query()
            ->where('owner_id', $id)
            ->get();
        return $questions;
    }

    public function index()
    {
        $questions = Question::query()
            ->where('owner_id', request()->user()->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('question.index', ['questions' => $questions]);
    }

    public function create()
    {
        $subjects = Subject::all();
        $users = User::all();
        return view('question.create', ["users" => $users, 'subjects' => $subjects]);
    }

    public function store(Request $request)
    {
        $question = new Question;
        $validatedData = $request->validate(['question' => 'required|string|max:1023']);
        $question->question = $validatedData['question'];

        $dropdownValue = $request->input('ownerInput');
        if (! empty($dropdownValue) && $dropdownValue != '0') {
            $user = User::where('name', $dropdownValue)->first();
            if ($user) {
                $question->owner_id = $user->id;
            } else {
                $question->owner_id = Auth::id();
            }
        } else
            $question->owner_id = Auth::id();

        if ($request->input('subject') != 0) {
            $subject = Subject::where('id', $request->input('subject'))->first();
            $question->subject()->associate($subject);
        } else {
            $subject = Subject::firstOrCreate(['subject' => $request->input('other_subject')]);
            $question->subject()->associate($subject);
        }

        $question->save();

        $i = 1;
        foreach ($request->all() as $key => $value) {
            if (str_starts_with($key, 'option')) {
                $correct = $request->input('isCorrect'.$i);
                $correct = isset($correct) ? true : false;
                $option = $question->options()->create(['option_text' => $value, 'correct' => $correct]);
                $option->save();
                $i++;
            }
        }
        return redirect()->route('question.index', $question);
    }

    public function show(Question $question)
    {
        if (! $question->active && $question->owner_id !== Auth::id()) {
            return redirect()->back();
        }
        $question->load('options');
        return view('question.show', ['question' => $question]);
    }

    public function edit(Question $question)
    {
        $subjects = Subject::all();
        if (Auth::user()->isAdmin()) {
            $users = User::all();
        } else {
            $users = null;
        }
        return view('question.edit', ['question' => $question, "users" => $users, 'subjects' => $subjects]);
    }

    public function update(Request $request, Question $question)
    {
        if ($request->input('active') !== null) {
            $isActive = $request->input('active');
            $question->update(['active' => $isActive, 'last_closed' => date('Y-m-d')]);

            if (! $isActive && $question->quiz_id !== null) {
                $question->update(['quiz_id' => null]);
            }

            return back();
        }

        $validatedData = $request->validate([
            'question' => 'sometimes|string|max:1023',
            'subject' => 'sometimes',
            'other_subject' => 'sometimes|max:255',
            'active' => 'sometimes|boolean',
        ]);

        $dropdownValue = $request->input('ownerInput');
        if (! empty($dropdownValue) && $dropdownValue != '0') {
            $user = User::where('name', $dropdownValue)->first();
            if ($user) {
                $question->owner_id = $user->id;
            } else {
                $question->owner_id = Auth::id();
            }
        } else
            $question->owner_id = Auth::id();
        if ($request->input('subject') != 0) {
            $subject = Subject::where('id', $request->input('subject'))->first();
            $question->subject()->associate($subject);
        } else {
            if (isset($subject)) {
                $subject = Subject::firstOrCreate(['subject' => $request->input('other_subject')]);
                $question->subject()->associate($subject);
            }
        }

        if (isset($validatedData['question'])) {
            $question->question = $validatedData['question'];
        }

        if (isset($validatedData['active'])) {
            $isActive = $validatedData['active'];
            $question->active = $isActive;

            if (! $isActive && $question->quiz_id !== null) {
                $question->quiz_id = null;
            }
        }

        $question->save();

        $question->options()->delete();
        $i = 1;
        foreach ($request->all() as $key => $value) {
            if (str_starts_with($key, 'option')) {
                $correct = $request->input('isCorrect'.$i);
                $correct = isset($correct) ? true : false;
                $option = $question->options()->create(['option_text' => $value, 'correct' => $correct]);
                $option->save();
                $i++;
            }
        }

        return to_route('questions')->with('message', 'Question was updated');
    }

    public function multiply(Question $question)
    {
        $newQuestion = $question->replicate();
        $newQuestion->save();

        $options = $question->options()->get();
        foreach ($options as $option) {
            $newOption = $option->replicate();
            $newOption->question_id = $newQuestion->id;
            $newOption->save();
        }

        return redirect()->route('question.index', $newQuestion);
    }

    public function destroy(Question $question)
    {
        $question->delete();
        return to_route('question.index')->with('message', 'Question was destroyed');
    }

    public function destroyAdmin(string $question_id)
    {
        $question = Question::find($question_id);
        $question->delete();
        return back();
    }
}
