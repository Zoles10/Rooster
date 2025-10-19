<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Subject;
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
            if ($user) {
                $quiz->owner_id = $user->id;
            } else {
                $quiz->owner_id = Auth::id();
            }
        } else
            $quiz->owner_id = Auth::id();

        $quiz->save();
        return redirect()->route('quizzes', $quiz);
    }
}
