@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex">
                        @if (isset($question))
                            Update your question
                        @else 
                            Ask a Question
                        @endif
                        <div class="ml-auto">
                            <a href="{{ route('questions.index') }}" class="btn btn-sm btn-outline-primary">
                                Return to all questions
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <form action="{{ isset($question) ? route('questions.update', $question->id) : route('questions.store') }}" method="post">
                        @csrf
                        @if (isset($question))
                            @method('PUT')
                        @endif
                        <div class="form-group">
                            <label for="question-title">Title</label>
                            <input type="text" class="form-control" id="question-title" name="title" value="{{ isset($question) ? $question->title : old('title') }}" placeholder="I cannot seem to find my dog! Can anyone help me with that?">
                            @error('title')
                                <div class="small text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="question-body">Body</label>
                            <textarea name="body" id="question-body" cols="30" rows="10" class="form-control" placeholder="Briefly describe your problem. Avoid repeating yourself and be clear so that everyone can try to help you">{{ isset($question) ? $question->body : old('body') }}</textarea>
                            @error('body')
                                <div class="small text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-sm btn-outline-primary">
                            @if (isset($question))
                                Update your question
                            @else
                                Submit question
                            @endif
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
