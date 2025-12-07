<x-app-layout>
    <div class="bg-white min-h-screen pt-5 flex flex-col items-center text-white">
        <div class="imp_margin_04 max-w-4xl w-full bg-gray-100 rounded-md shadow-lg shadow-gray-400 text-black relative">
            <div class="imp_bg_white w-full px-6 md:px-8 py-4 rounded-t-lg">
                <h1 class="text-2xl font-bold text-center">{{ $question->question }}</h1>
            </div>
            <div class="p-6 md:p-8">
                <form id="answer-form" action="{{ route('answer.store', ['id' => $question->id]) }}" method="POST">
                    @csrf
                    @php
                        $correctOptionsCount = $question->options->where('correct', 1)->count();
                    @endphp
                    <input type="hidden" id="correctOptionsCount" value="{{ $correctOptionsCount }}">
                    @foreach ($question->options as $index => $option)
                        <div class="border p-3 my-2 rounded bg-light border-gray-500">
                            <input class="form-check-input form-checkbox h-5 w-5 text-indigo-600 ml-1 p-2 rounded "
                                type="checkbox" name="selected{{ $index + 1 }}" id="option{{ $index + 1 }}"
                                value="{{ $option->option_text }}" onclick="limitCheckboxes()" disabled>
                            <label class="form-check-label ml-1 mt-1" for="option{{ $index + 1 }}">
                                {{ $option->option_text }}
                            </label>
                        </div>
                    @endforeach
                </form>
                @if (Auth::id() == $question->owner_id)
                    @include('question.ownerShow')
                @endif
            </div>
            <div class="px-6 md:px-8">
                <a href="/questions"
                    class="absolute bottom-6 px-4 py-2 bg-slate-500 rounded-md text-white hover:bg-slate-700 flex items-center h-9 transition-colors duration-150">
                    @svg('mdi-arrow-left', 'w-5 h-5 mr-1')
                    @lang('messages.back')</a>
            </div>
        </div>
    </div>
    @vite('resources/js/showQuestion.js')
</x-app-layout>
