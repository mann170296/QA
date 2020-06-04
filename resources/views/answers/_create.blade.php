<div class="card mt-2">
    <div class="card-header">
        <h3>
            Your answer
        </h3>
    </div>
    <div class="card-body">
        <form action="{{ route('questions.answers.store', $question->id) }}" method="post">
            @csrf
            <div class="form-group">
                <textarea name="body" cols="30" rows="7" class="form-control" placeholder="Some brief informative answer. Avoid one liners unless they solve the actual problem."></textarea>
            </div>

            <button type="submit" class="btn btn-outline-primary btn-sm">Add answer</button>
        </form>
    </div>
</div>