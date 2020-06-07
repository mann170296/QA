<?php

use Illuminate\Database\Seeder;

use App\User;
use App\Question;
use App\Answer;

class VotablesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('votables')->delete();

        $users = User::all();
        $numberOfUsers = $users->count();
        $vote = [-1, 1];

        foreach(Question::all() as $question) {
            for($i = 0; $i < rand(1, $numberOfUsers); $i++) {
                $user = $users[$i];
                $user->voteTheQuestion($question, $vote[rand(0, 1)]);
            }
        }

        foreach(Answer::all() as $answer) {
            for($i = 0; $i < rand(1, $numberOfUsers); $i++) {
                $user = $users[$i];
                $user->voteTheAnswer($answer, $vote[rand(0, 1)]);
            }
        }
    }
}
