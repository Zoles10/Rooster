<h1>{{ $quiz->title }}</h1>
<p>{{ $quiz->description }}</p>
<p>User: {{ $user->name }}</p>
<hr>
@foreach ($questions as $question)
    <h3>{{ $question->question }}</h3>
    <ul>
        @foreach ($question->options as $option)
            <li>
                {{ $option->option_text }}
                @if (isset($answers[$question->id]) && $answers[$question->id]->contains('option_id', $option->id))
                    <strong style="color: green;">&#10003; Selected</strong>
                @endif
                @if ($option->correct)
                    <span style="color: blue;">(Correct)</span>
                @endif
            </li>
        @endforeach
    </ul>
@endforeach
