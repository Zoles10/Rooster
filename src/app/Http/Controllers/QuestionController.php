<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Subject;
use App\Models\User;
use App\Models\OptionsHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */

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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $subjects = Subject::all();
        $users = User::all();
        return view('question.create', ["users" => $users, 'subjects' => $subjects]);
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
            'word_cloud' => 'required|boolean|in:0,1',
        ]);
        $question->question = $validatedData['question'];
        $question->question_type = $validatedData['question_type'];
        $question->word_cloud = $validatedData['word_cloud'];

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

        if ($validatedData['question_type'] === 'multiple_choice') {
            $i = 1;
            foreach ($request->all() as $key => $value) {
                if (str_starts_with($key, 'option')) {
                    $correct = $request->input('isCorrect' . $i);
                    $correct = isset($correct) ? true : false;
                    $option = $question->options()->create(['option_text' => $value, 'correct' => $correct]);
                    $optionHistory = $option->optionsHistory()->create([
                        'option_id' => $option->id,
                        'year' => date('Y'),
                        'times_answered' => 0
                    ]);
                    $optionHistory->save();
                    $option->save();
                    $i++;
                }
            }
        }
        return redirect()->route('question.index', $question);
    }

    /**
     * Display the specified resource.
     */
    public function show(Question $question)
    {
        if (! $question->active && $question->owner_id !== Auth::id()) {
            return redirect()->back();
        }
        //options budu v $question->options
        $question->load('options');
        return view('question.show', ['question' => $question]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Question $question)
    {
        $subjects = Subject::all();
        if(Auth::user()->isAdmin()) {
            $users = User::all();
        } else {
            $users = null;
        }
        return view('question.edit', ['question' => $question, "users" => $users, 'subjects' => $subjects]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Question $question)
    {
        if($request->input('active') !== null) {
            $question->update(['active' => $request->input('active'), 'last_closed' => date('Y-m-d'), 'last_note' => $request->input('note')]);

            if($request->input('active') === '0') {
                if($question->question_type == 'open_ended') {
                    $answers = $question->answers()->get();
                    foreach($answers as $answer) {
                        $answer->update(['archived' => true]);
                    }
                } else {
                    $options = $question->options()->get();
                    foreach($options as $option) {
                        $option->optionsHistory()->update(['archived' => true]);
                        $option->optionsHistory()->create([
                            'option_id' => $option->id,
                            'year' => date('Y'),
                            'times_answered' => 0
                        ]);
                    }
                }
            }

            return back();
        }

        $validatedData = $request->validate([
            'question' => 'sometimes|string|max:1023',
            'subject' => 'sometimes',
            'other_subject' => 'sometimes|max:255',
            'active' => 'sometimes|boolean',
            'word_cloud' => 'sometimes|boolean'
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
            $question->active = $validatedData['active'];
        }

        if (isset($validatedData['word_cloud'])) {
            $question->word_cloud = $validatedData['word_cloud'] === '1' ? true : false;
        }

        $question->save();

        if ($question->question_type === 'multiple_choice') {
            $question->options()->delete();
            $i = 1;
            foreach ($request->all() as $key => $value) {
                if (str_starts_with($key, 'option')) {
                    $correct = $request->input('isCorrect' . $i);
                    $correct = isset($correct) ? true : false;
                    $option = $question->options()->create(['option_text' => $value, 'correct' => $correct]);
                    $option->optionsHistory()->create([
                        'option_id' => $option->id,
                        'year' => date('Y'),
                        'times_answered' => 0
                    ]);
                    $option->save();
                    $i++;
                }
            }
        }

        return to_route('dashboard')->with('message', ('Question was updated'));
    }

    public function multiply(Question $question)
    {
        $newQuestion = $question->replicate();
        $newQuestion->save();

        // Copy related models
        $options = $question->options()->get();
        foreach ($options as $option) {
            $newOption = $option->replicate();
            $newOption->question_id = $newQuestion->id;
            $newOption->save();
        }

        return redirect()->route('question.index', $newQuestion);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Question $question)
    {
        $question->delete();

        return to_route('question.index')->with('message', ('Question was destroyed'));
    }

    public function destroyAdmin(string $question_id)
    {
        $question = Question::find($question_id);
        $question->delete();
        return back();
    }

    public function export(Question $question)
    {
        if ($question->question_type === 'open_ended') {
            $answers = $question->answers()->where('archived', false)->get();
            $csvData = [['Answer ID', 'Answer text', 'Created at']];
            foreach ($answers as $answer) {
                $csvData[] = [$answer->id, $answer->user_text, $answer->created_at];
            }
            $csvFileName = $question->id . '-export.csv';
            $csvFile = fopen($csvFileName, 'w');
            foreach ($csvData as $row) {
                fputcsv($csvFile, $row);
            }
            fclose($csvFile);
            return response()->download($csvFileName)->deleteFileAfterSend(true);
        } else {
            $options = $question->options()->get();
            $csvData = [];
            $csvData = [['Option ID', 'Option Text', 'Correct', 'Times answered']];
            foreach ($options as $option) {
                $csvData[] = [$option->id, $option->option_text, $option->correct, $option->optionsHistory()->first()->times_answered];
            }
            $csvFileName = $question->id . '-export.csv';
            $csvFile = fopen($csvFileName, 'w');
            foreach ($csvData as $row) {
                fputcsv($csvFile, $row);
            }
            fclose($csvFile);
            return response()->download($csvFileName)->deleteFileAfterSend(true);
        }
    }
}
