<?php

namespace App\Http\Controllers;

use App\Question;
use Auth;

use Illuminate\Http\Request;

use App\Http\Requests\Questions\CreateQuestion;

class QuestionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = Question::with('user')->latest()->paginate(3);

        return view('questions.index')->with('questions', $questions);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(\Gate::allows('create-question')) {
            return view('questions.create');
        } else {
            return redirect()->back();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateQuestion $request)
    {
        $create = $request->user()->questions()->create([
            'title' => $request->title,
            'body' => $request->body,
        ]);

        session()->flash('success', 'Your question was added');

        return redirect('questions');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        $question->increment('views');
        return view('questions.show')->with('question', $question);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {
        if(\Gate::allows('modify-question', $question)) {
            return view('questions.create')->with('question', $question);
        } else {
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(CreateQuestion $request, Question $question)
    {
        if(\Gate::allows('modify-question', $question)) {
            $question->update([
                'title' => $request->title,
                'body' => $request->body,
            ]);
    
            session()->flash('success', 'Your question was updated successfully');
    
            return redirect('questions');
        } else {
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        if(\Gate::allows('modify-question', $question)) {
            if(\Gate::allows('questionWithNoAnswer', $question)) {
                $question->delete();

                session()->flash('success', 'Your question was deleted successfully');

                return redirect()->back();
            } else {
                session()->flash('error', 'You cannot delete a question with one or more answers');

                return redirect()->back();
            }
        } else {
            session()->flash('error', 'Your action was not authorized');

            return redirect()->back();
        }
    }
}
