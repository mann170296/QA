<div class="card mt-2">
    <div class="card-header">
        <h3>
            {{ $question->answers_count }}
            {{ Str::plural('answer',$question->answers_count) }}
        </h3>
    </div>
    <div class="card-body">
        @include('partials.success')
        @foreach ($question->answers as $answer)
            <div class="div row">
                <div class="col-md-10">
                   <p>
                       {!! $answer->body !!}
                   </p>
                   <div class="col-md-6">
                        <div style="margin-top: 40px;">
                            <img src="{{ $answer->avatar }}" alt="">
                            <span class="text-muted">
                                {{ $answer->user->name }}

                                <b>[ </b>{{ $answer->answered_at }}<b> ]</b>
                                <br>
                            </span>
                        </div>
                        <br>
                        @can('modifyAnswer', $answer)
                            <div class="row">
                                <a href="{{ route('questions.answers.edit', [$question->id, $answer->id]) }}" class="btn btn-sm btn-outline-info">
                                    Edit
                                </a>
                                &nbsp;
                                <form action="{{ route('questions.answers.destroy', [$question->id, $answer->id]) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        @endcan
                   </div>
                </div>
                <div class="col-md-2">
                    <div class="d-flex flex-column mx-auto">
                        <a title="This question is useful" class="vote_up mx-auto">
                            <i class="fas fa-caret-up fa-3x"></i>
                        </a>
                        <div class="votes mx-auto">
                            <strong class="vote__count">{{ $answer->votes_count }}</strong> {{ Str::plural('vote',$question->votes) }}
                        </div>
                        <a title="This question is not useful" class="vote_down mx-auto">
                            <i class="fas fa-caret-down fa-3x"></i>
                        </a>
                        <a title="Mark as best answer" class="best_answer {{ $answer->bestAnswer }} mx-auto">
                            <i class="fas fa-check fa-2x"></i>
                        </a>
                    </div>
                </div>
            </div>
            <br>
            <hr>
            <br>
        @endforeach
    </div>
</div>