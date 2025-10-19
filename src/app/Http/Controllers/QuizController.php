<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    public function index(Request $request)
    {
        $quizzes = Quiz::query()
            ->where('owner_id', request()->user()->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('quiz.index', ['quizzes' => $quizzes]);
    }

    public function show(Quiz $quiz)
    {
        if (! $quiz->active && $quiz->owner_id !== Auth::id()) {
            return redirect()->back();
        }
        return view('quiz.show', ['quiz' => $quiz]);
    }

    public function create()
    {
        $users = User::all();
        return view('quiz.create', ["users" => $users]);
    }

    public function store(Request $request)
    {
        $quiz = new Quiz;
        $validatedData = $request->validate(['quiz' => 'required|string|max:255', 'quizDescription' => 'required|string|max:1023']);
        $quiz->title = $validatedData['quiz'];
        $quiz->description = $validatedData['quizDescription'];

        $dropdownValue = $request->input('ownerInput');
        if (! empty($dropdownValue) && $dropdownValue != '0') {
            $user = User::where('name', $dropdownValue)->first();
            if ($user)
                $quiz->owner_id = $user->id;
            else
                $quiz->owner_id = Auth::id();
        } else
            $quiz->owner_id = Auth::id();

        $quiz->save();
        return redirect()->route('quizzes', $quiz);
    }

    public function edit(Quiz $quiz)
    {
        if (Auth::user()->isAdmin())
            $users = User::all();
        else
            $users = null;
        return view('quiz.edit', ['quiz' => $quiz, "users" => $users]);
    }

    public function update(Request $request, Quiz $quiz)
    {
        if ($request->input('active') !== null) {
            $quiz->update(['active' => $request->input('active'), 'last_closed' => date('Y-m-d')]);
            return back();
        }

        $validatedData = $request->validate([
            'quiz' => 'sometimes|string|max:255',
            'quizDescription' => 'sometimes|string|max:1023',
            'active' => 'sometimes|boolean',
        ]);

        $dropdownValue = $request->input('ownerInput');
        if (! empty($dropdownValue) && $dropdownValue != '0') {
            $user = User::where('name', $dropdownValue)->first();
            if ($user) {
                $quiz->owner_id = $user->id;
            } else {
                $quiz->owner_id = Auth::id();
            }
        } else
            $quiz->owner_id = Auth::id();

        if (isset($validatedData['active'])) {
            $quiz->active = $validatedData['active'];
        }

        if (isset($validatedData['quiz'])) {
            $quiz->title = $validatedData['quiz'];
        }

        if (isset($validatedData['quizDescription'])) {
            $quiz->description = $validatedData['quizDescription'];
        }

        $quiz->save();

        return to_route('quizzes')->with('message', 'Quiz was updated');
    }

    public function multiply(Quiz $quiz)
    {
        $newQuiz = $quiz->replicate();
        $newQuiz->save();
        return redirect()->route('quiz.index', $newQuiz);
    }

    public function destroy(Quiz $quiz)
    {
        $quiz->delete();
        return to_route('quiz.index')->with('message', 'Quiz was destroyed');
    }

    public function destroyAdmin(string $question_id)
    {
        $question = Quiz::find($question_id);
        $question->delete();
        return back();
    }
}
