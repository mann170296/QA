<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Question extends Model
{
    protected $fillable = ['title', 'body'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function answers() {
        return $this->hasMany(Answer::class);
    }

    // Mutator to set the slug according to the title
    public function setTitleAttribute($value) {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function getUrlAttribute() {
        return route('questions.show', $this->slug);
    }

    public function getAskedWhenAttribute() {
        return $this->created_at->diffForHumans();
    }

    public function getEditedAtAttribute() {
        return $this->updated_at->diffForHumans();
    }

    public function getStatusAttribute() {
        if($this->answers_count > 0) {
            if($this->best_answer_id) {
                return "answer-accepted";
            }
            return "answered";
        }

        return "unanswered";
    }

    // Accepts the answer as best answer
    public function acceptBestAnswer($id) {
        $this->best_answer_id = $id;

        $this->save();
    }

    // Polymorphic
    public function votes() {
        return $this->morphToMany(User::class, 'votable');
    }

    public function upVote() {
        return $this->votes()->wherePivot('vote', 1);
    }

    public function downVote() {
        return $this->votes()->wherePivot('vote', -1);
    }
}
