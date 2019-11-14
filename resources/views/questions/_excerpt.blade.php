<div class="media post">
    <div class="d-flex flex-column counters">
        <div class="vote">
            <strong>{{ $question->vote_count }}</strong> {{ str_plural('vote', $question->vote_count) }}
        </div>
        <div class="status {{ $question->status }}">
            <strong>{{ $question->answer_count }}</strong> {{ str_plural('answer', $question->answer_count) }}
        </div>
        <div class="view">
            {{ $question->views . " " . str_plural('view', $question->answer_count) }}
        </div>
    </div>
    <div class="media-body">
        <div class="d-flex align-items-center">
            <h3 class="mt-0"><a href="{{ $question->url }}">{{ $question->title }}</a></h3>
            <div class="ml-auto">
                {{-- @if (Auth::user()->can('update', $question))    
                @endif
                @if (Auth::user()->can('delete', $question))
                @endif --}}
                @can('update', $question)
                    <a href="{{ route('questions.edit', $question->id) }}" class="btn btn-sm btn-outline-info">Edit</a>
                @endcan
                
                @can('delete', $question)
                    <form class="form-delete" action="{{ route('questions.destroy', $question->id) }}" method="POST">
                        @method('DELETE')
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                @endcan
            </div>
        </div>
        <p class="lead">
            Asked by
            <a href="{{ $question->user->url }}">{{ $question->user->name }}</a>
            <small class="text-muted">{{ $question->created_date }}</small>
        </p>
        <div class="excerpt">{{ $question->excerpt }}</div>
        {{-- <div class="excerpt">{!! str_limit(strip_tags($question->body_html), 300) !!}</div> --}}
    </div>
</div>