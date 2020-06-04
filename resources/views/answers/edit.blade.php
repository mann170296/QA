@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card mt-2">
        <div class="card-header">
            <h3>
                Edit you answer
            </h3>
        </div>
        <div class="card-body">
            <form action="{{ route('questions.answers.update', [$question->id, $answer->id]) }}" method="post">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <textarea name="body" cols="30" rows="7" class="form-control">{{ $answer->body }}</textarea>
                </div>
    
                <button type="submit" class="btn btn-outline-primary btn-sm">
                    Update your answer
                </button>
            </form>
        </div>
    </div>
</div>
@endsection