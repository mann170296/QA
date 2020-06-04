@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex">
                        Questions
                        <div class="ml-auto">
                            @auth
                                <a href="{{ route('questions.create') }}" class="btn btn-sm btn-outline-primary">
                                    Ask a question
                                </a>
                            @else
                                <a href="{{ route('register') }}" class="btn btn-sm btn-outline-success">
                                    Login to ask a question
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @include('partials.success')
                    @include('partials.error')
                    @foreach ($questions as $question)
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="d-flex flex-column mx-auto">
                                        <div class="votes mx-auto">
                                            <strong class="vote__count">{{ $question->votes }}</strong> {{ Str::plural('vote',$question->votes) }}
                                        </div>

                                        <div class="status mx-auto">
                                            <strong class="answer__count {{ $question->status }} mx-auto">
                                                <span class="answer__count-number">{{ $question->answers_count }}</span>
                                            </strong> 
                                            {{ Str::plural('answer',$question->_count) }}
                                        </div>

                                        <div class="views mx-auto">
                                            <span class="view__count">{{ $question->views }}</span>  {{ Str::plural('view',$question->views) }}
                                        </div>
                                    </div>
                                </div>
                                @can('modify-question', $question)
                                    <div class="col-md-8">
                                @endcan
                                @cannot('modify-question', $question)
                                    <div class="col-md-10">
                                @endcannot
                                    <h4>
                                        <a href="{{ $question->url }}">
                                            {{ $question->title }}
                                        </a>
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
                                    <p>{{ Str::limit($question->body, 200) }}</p>
                                    <hr>
                                </div>
                                @can('modify-question', $question)
                                    <div class="col-md-2">
                                        <div class="row">
                                            <a href="{{ route('questions.edit', $question->id) }}" class="btn btn-sm btn-outline-info">
                                                Edit
                                            </a>
                                            &nbsp;
                                            <form action="{{ route('questions.destroy', $question->id) }}" method="post">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endcan
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="card-footer">
                    {{ $questions->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
