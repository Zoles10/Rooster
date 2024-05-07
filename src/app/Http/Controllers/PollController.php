<?php

namespace App\Http\Controllers;

use App\Models\Poll;
use App\Models\Question;
use Illuminate\Http\Request;

class PollController extends Controller
{
    public function index()
    {
        return view('poll.index');
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
        $poll = new Poll;
        $poll->save();

        return redirect()->route('poll.show', $poll);
    }

    /**
     * Display the specified resource.
     */
    public function show(Poll $poll)
    {
        $questions = Question::withPollId($poll->id)->get();
        return view('poll.show', compact('poll', 'questions'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Poll $poll)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Poll $poll)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Poll $poll)
    {
        //
    }
}
