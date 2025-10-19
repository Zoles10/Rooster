<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\User;
use App\Models\Question;
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
        if (Auth::user()->isAdmin())
            $users = User::all();

        $questions = Question::where('owner_id', request()->user()->id)
            ->where('active', true)
            ->get();
        return view('quiz.create', ["users" => $users, "questions" => $questions]);
    }

    public function store(Request $request)
    {
        $quiz = new Quiz;
        $validatedData = $request->validate([
            'quiz' => 'required|string|max:255',
            'quizDescription' => 'required|string|max:1023',
            'selected_questions' => 'required|array|min:1',
            'selected_questions.*' => 'integer|exists:questions,id'
        ]);

        $selectedIds = $validatedData['selected_questions'];

        $alreadyAssigned = Question::whereIn('id', $selectedIds)
            ->whereNotNull('quiz_id')
            ->pluck('id')
            ->toArray();

        if (! empty($alreadyAssigned)) {
            return back()
                ->withInput()
                ->withErrors(['selected_questions' => 'The following question IDs are already assigned to a quiz: '.implode(', ', $alreadyAssigned)]);
        }

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
        $ids = $validatedData['selected_questions'];
        Question::whereIn('id', $ids)->update(['quiz_id' => $quiz->id]);
        return redirect()->route('quizzes', $quiz);
    }

    public function edit(Quiz $quiz)
    {
        if (Auth::user()->isAdmin())
            $users = User::all();
        else
            $users = null;

        $questions = Question::where('owner_id', request()->user()->id)
            ->where('active', true)
            ->get();

        return view('quiz.edit', ['quiz' => $quiz, "users" => $users, 'questions' => $questions]);
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
            'selected_questions' => 'sometimes|array',
            'selected_questions.*' => 'integer|exists:questions,id'
        ]);

        $selectedIds = $validatedData['selected_questions'] ?? [];

        // Deep copy questions that belong to other quizzes
        $finalIds = [];
        if (! empty($selectedIds)) {
            foreach ($selectedIds as $questionId) {
                $question = Question::find($questionId);

                // If question belongs to another quiz, duplicate it
                if ($question->quiz_id !== null && $question->quiz_id !== $quiz->id) {
                    $newQuestion = $question->replicate();
                    $newQuestion->quiz_id = null; // will be set below
                    $newQuestion->save();

                    // Duplicate all options
                    foreach ($question->options as $option) {
                        $newOption = $option->replicate();
                        $newOption->question_id = $newQuestion->id;
                        $newOption->save();
                    }

                    $finalIds[] = $newQuestion->id;
                } else {
                    $finalIds[] = $questionId;
                }
            }
        }

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

        Question::where('quiz_id', $quiz->id)
            ->whereNotIn('id', $finalIds)
            ->update(['quiz_id' => null]);

        if (! empty($finalIds)) {
            Question::whereIn('id', $finalIds)->update(['quiz_id' => $quiz->id]);
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
        Question::where('quiz_id', $quiz->id)->update(['quiz_id' => null]);
        $quiz->delete();
        return to_route('quiz.index')->with('message', 'Quiz was destroyed');
    }

    public function destroyAdmin(string $quiz_id)
    {
        Question::where('quiz_id', $quiz_id)->update(['quiz_id' => null]);
        $quiz = Quiz::find($quiz_id);
        $quiz->delete();
        return back();
    }
}
