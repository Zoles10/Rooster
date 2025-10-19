<x-app-layout>
    <div class="container mx-auto my-5 p-5">
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-xl mb-3">{{ $question->question }}</h2>
            <form id="answer-form" action="{{ route('answer.store', ['id' => $question->id]) }}" method="POST">
                @csrf
                @php
                    $correctOptionsCount = $question->options->where('correct', 1)->count();
                @endphp
                <input type="hidden" id="correctOptionsCount" value="{{ $correctOptionsCount }}">
                @foreach ($question->options as $index => $option)
                    <div class="border p-3 m-2 rounded bg-light border-violet-600">
                        <input class="form-check-input form-checkbox h-5 w-5 text-indigo-600 ml-1 p-2 rounded "
                            type="checkbox" name="selected{{ $index + 1 }}" id="option{{ $index + 1 }}"
                            value="{{ $option->option_text }}" onclick="limitCheckboxes()">
                        <label class="form-check-label ml-1 mt-1" for="option{{ $index + 1 }}">
                            {{ $option->option_text }}
                        </label>
                    </div>
                @endforeach
                @method('POST')
                <button type="submit" id="submit-btn"
                    class="mt-2 mr-2 px-4 py-2 bg-blue-500 rounded-md text-white hover:bg-blue-600">@lang('messages.send')</button>
                <button type="reset"
                    class="mt-2 mr-2 px-4 py-2 bg-red-500 rounded-md text-white hover:bg-red-600">@lang('messages.clear')</button>
                @if (Auth::id() == $question->owner_id)
                    <a href="/questions"
                        class="inline-block px-4 py-2 bg-green-500 rounded-md text-white hover:bg-green-600">@lang('messages.back')</a>
                @else
                    <a href="/"
                        class="inline-block px-4 py-2 bg-green-500 rounded-md text-white hover:bg-green-600">@lang('messages.back')</a>
                @endif
            </form>
            @if (Auth::id() == $question->owner_id)
                @include('question.ownerShow')
            @endif
        </div>
    </div>
    @vite('resources/js/showQuestion.js')
</x-app-layout>
