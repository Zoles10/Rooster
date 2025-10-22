<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Quiz;
use Carbon\Traits\ToStringFormat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    public function getAll()
    {
        return User::all();
    }

    public function getById(string $id)
    {
        $user = User::find($id);
        if (! $user)
            return null;
        return $user;
    }

    public function getUserQuestionsByUserId(string $id)
    {
        $user = User::find($id);
        if ($user) {
            return $user->questions;
        }
        return null;
    }

    public function indexQuestions()
    {
        $questions = Question::with('user')->paginate(10);

        foreach ($questions as $question) {
            $question->user_name = $question->user->name;
            $question->subject;
        }

        return view('admin.adminQuestionBoard', ["questions" => $questions]);
    }

    public function indexQuizzes()
    {
        $quizes = Quiz::with('user')->paginate(10);

        foreach ($quizes as $quiz) {
            $quiz->owner_name = $quiz->user->name;
        }
        return view('admin.adminQuizBoard', ["quizzes" => $quizes]);
    }

    public function index()
    {
        $users = User::all();
        return view('admin.adminUserBoard', ["users" => $users]);
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return back();
    }

    public function edit(Request $request, User $user)
    {
        $request->validate([
            'password' => 'required',
        ]);

        $user->password = Hash::make($request->password);
        $user->save();

        return back();
    }

    public function editName(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $user->name = $request->name;
        $user->save();

        return back();
    }

    public function update(Request $request, User $user)
    {
        $user->admin = $request->has('admin');
        $user->save();

        return back();
    }

    public function destroy(User $user)
    {
        $user->delete();
        return back();
    }
}
