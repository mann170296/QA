<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable = ['body', 'user_id'];

    public function question() {
        return $this->belongsTo(Question::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function getAvatarAttribute() {
        $email = $this->user->email;
        $size = 32;

        return "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "?s=" . $size;

    }

    public function getAnsweredAtAttribute() {
        return $this->created_at->diffForHumans();
    }

    public function getBestAnswerAttribute() {
        if($this->id === $this->question->best_answer_id) {
            return "answer_accepted";
        }
    }
}
