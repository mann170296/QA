<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Question;

use App\Http\Requests\CreateAnswerRequest;

use Illuminate\Http\Request;

class AnswersController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateAnswerRequest $request, Question $question)
    {
        $currentUserID = \Auth::id();

        $question->answers()->create([
            'body' => $request->body,
            'user_id' => $currentUserID,
        ]);

        session()->flash('success', 'Answer created successfully');

        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question, Answer $answer)
    {
        if(\Gate::allows('modifyAnswer', $answer)) {
            return view('answers.edit', compact('question', 'answer'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function update(CreateAnswerRequest $request, Question $question, Answer $answer)
    {
        if(\Gate::allows('modifyAnswer', $answer)) {
            $answer->update([
                'body' => $request->body,
            ]);
    
            session()->flash('success', 'Answer updated successfully');
    
            return redirect('questions/' . $question->slug);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question, Answer $answer)
    {
        if(\Gate::allows('modifyAnswer', $answer)) {
            $answer->delete();
            session()->flash('success', 'Your answer was deleted successfully');
            return redirect()->back();
        }
    }

    public function accept(Answer $answer) {
        $answer->question->acceptBestAnswer($answer->id);

        return back();
    }
}
