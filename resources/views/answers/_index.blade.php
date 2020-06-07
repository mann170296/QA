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
                        @auth
                            <a title="This answer is useful" class="vote_up mx-auto"
                            onclick="event.preventDefault(); document.getElementById('up-vote-answer-{{ $answer->id }}').submit()">
                                <i class="fas fa-caret-up fa-3x"></i>
                            </a>

                            <form action="{{ route('answer.vote', $answer->id) }}" method="POST" id="up-vote-answer-{{ $answer->id }}" style="display: none">
                                @csrf
                                <input type="hidden" name="vote" value="1">
                            </form>
                        @endauth
                        <div class="votes mx-auto">
                            <strong class="vote__count">{{ $answer->votes_count }}</strong> {{ Str::plural('vote', $answer->votes_count) }}
                        </div>
                        @auth
                            <a title="This answer is not useful" class="vote_down mx-auto"
                            onclick="event.preventDefault(); document.getElementById('down-vote-answer-{{ $answer->id }}').submit()">
                                <i class="fas fa-caret-down fa-3x"></i>
                            </a>

                            <form action="{{ route('answer.vote', $answer->id) }}" method="POST" id="down-vote-answer-{{ $answer->id }}" style="display: none">
                                @csrf
                                <input type="hidden" name="vote" value="-1">
                            </form>
                        @endauth
                        @can('acceptAnswer', $answer->question)
                            <a title="Mark as best answer" class="best_answer {{ $answer->bestAnswer }} mx-auto"
                                onclick="event.preventDefault(); document.getElementById('accept_answer_{{ $answer->id }}').submit();">
                                <i class="fas fa-check fa-2x"></i>
                            </a>
                        @else
                            @if ($answer->is_best)
                                <a title="This answer was accepted by owner as best answer" class="best_answer {{ $answer->bestAnswer }} mx-auto">
                                    <i class="fas fa-check fa-2x"></i>
                                </a>
                            @endif
                        @endcan
                    </div>

                <form action="{{ route('answer.accept', $answer->id) }}" method="POST" id="accept_answer_{{ $answer->id }}" style="display: none">
                    @csrf
                </form>
                </div>
            </div>
            <br>
            <hr>
            <br>
        @endforeach
    </div>
</div>