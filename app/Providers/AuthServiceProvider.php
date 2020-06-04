<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Auth;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Gate for creating a question
        // only logged in user can create a new question
        Gate::define('create-question', function($user) {
            return Auth::check();
        });

        // Gate for updating or deleting question
        // One can only update questions asked by them.
        Gate::define('modify-question', function($user, $question) {
            if($user->role === 'admin') {
                return true;
            } else if($user->id === $question->user_id) {
                return true;
            } else {
                return false;
            }
        });

        Gate::define('questionWithNoAnswer', function($user, $question) {
            if($question->answers_count < 1) {
                return true;
            } else {
                return false;
            }
        });

        // Only owner can edit or delete the answer (or an admin)
        Gate::define('modifyAnswer', function($user, $answer) {
            if($user->role === 'admin') {
                return true;
            } else if($user->id === $answer->user_id) {
                return true;
            } else {
                return false;
            }
        });

        // Authorize for deletion
        Gate::define('deleteAnswer', function($user, $answer) {
            // Set best answer ID to null if the best answer was deleted
            if($answer->id === $answer->question->best_answer_id) {
                $answer->question->best_answer_id = NULL;
                $answer->question->save();
            }

            return true;
        });
    }
}
