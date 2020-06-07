<?php

namespace App;

use App\Question;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getUrlAttribute() {
        return '#';
    }

    public function questions() {
        return $this->hasMany(Question::class);
    }

    public function answers() {
        return $this->hasMany(Answer::class);
    }

    // Polymorphic relationship
    public function voteQuestions() {
        return $this->morphedByMany(Question::class, 'votable');
    }

    // Polymorphic relationship
    public function voteAnswers() {
        return $this->morphedByMany(Answer::class, 'votable');
    }

    public function voteTheQuestion(Question $question, $vote) {
        $voteQuestions = $this->voteQuestions();
        if($voteQuestions->where('votable_id', $question->id)->exists()) {
            $voteQuestions->updateExistingPivot($question, ['vote' => $vote]);
        } else {
            $voteQuestions->attach($question, ['vote' => $vote]);
        }

        $question->load('votes');
        $upVotes = (int) $question->upVote()->sum('vote');
        $downVotes = (int) $question->downVote()->wherePivot('vote', -1)->sum('vote');

        // save to votes_count in DB
        $question->votes_count = $upVotes + $downVotes;
        $question->save();
    }

    public function voteTheAnswer(Answer $answer, $vote) {
        $voteAnswers = $this->voteAnswers();
        if($voteAnswers->where('votable_id', $answer->id)->exists()) {
            $voteAnswers->updateExistingPivot($answer, ['vote' => $vote]);
        } else {
            $voteAnswers->attach($answer, ['vote' => $vote]);
        }

        $answer->load('votes');
        $upVotes = (int) $answer->upVote()->sum('vote');
        $downVotes = (int) $answer->downVote()->wherePivot('vote', -1)->sum('vote');

        // save to votes_count in DB
        $answer->votes_count = $upVotes + $downVotes;
        $answer->save();
    }
}
