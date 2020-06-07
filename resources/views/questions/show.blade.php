@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex">
                        Question
                        <div class="ml-auto">
                            <a href="{{ route('questions.index') }}" class="btn btn-sm btn-outline-primary">
                                Return to all questions
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="d-flex flex-column mx-auto">
                                @auth
                                    <a title="This question is useful" class="vote_up mx-auto"
                                         onclick="event.preventDefault(); document.getElementById('up-vote-question-{{ $question->id }}').submit()">
                                        <i class="fas fa-caret-up fa-3x"></i>
                                    </a>

                                    <form action="{{ route('question.vote', $question->id) }}" method="POST" id="up-vote-question-{{ $question->id }}" style="display: none">
                                        @csrf
                                        <input type="hidden" name="vote" value="1">
                                    </form>
                                @endauth
                                <div class="votes mx-auto">
                                    <strong class="vote__count">{{ $question->votes_count }}</strong> {{ Str::plural('vote',$question->votes_count) }}
                                </div>
                                @auth
                                    <a title="This question is not useful" class="vote_down mx-auto" style="cursor: pointer"
                                    onclick="event.preventDefault(); document.getElementById('down-vote-question-{{ $question->id }}').submit()">
                                        <i class="fas fa-caret-down fa-3x"></i>
                                    </a>

                                    <form action="{{ route('question.vote', $question->id) }}" method="POST" id="down-vote-question-{{ $question->id }}" style="display: none">
                                        @csrf
                                        <input type="hidden" name="vote" value="-1">
                                    </form>
                                @endauth
                                <div class="views mx-auto">
                                    <span class="view__count">{{ $question->views }}</span>  {{ Str::plural('view',$question->views) }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <h4>
                                {{ $question->title }}
                            </h4>
                            <p class="lead" style="font-size: 14px;">
                                asked by 
                                <a href="{{ $question->user->url }}">
                                    {{ $question->user->name }}
                                </a>
                                <span class="text-muted">
                                    {{ $question->asked_when }}
                                </span>
                                @if ($question->asked_when != $question->edited_at)
                                    <span class="text-muted">
                                        [ edited
                                        {{ $question->edited_at }} ]
                                    </span>
                                @endif
                            </p>
                            <p>{!! $question->body !!}</p>
                        </div>
                    </div>
                </div>
                <br>
            </div>

            @include('answers._index')

            @include('answers._create')
        </div>
    </div>
</div>
@endsection
