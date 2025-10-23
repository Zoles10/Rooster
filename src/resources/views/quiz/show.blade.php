@section('title', __('messages.quizShow'))
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $quiz->title }}
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 m-4">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h3 class="text-lg font-semibold mb-2">{{ $quiz->description }}</h3>
            </div>

            <form id="quiz-answer-form" action="{{ route('quiz.submitAnswers', $quiz->id) }}" method="POST" class="p-6">
                @csrf

                @foreach ($quiz->questions as $index => $question)
                    <div class="mb-8 p-6 bg-gray-50 rounded-lg border border-gray-200">
                        <h4 class="text-xl mb-4 font-semibold">{{ $index + 1 }}. {{ $question->question }}</h4>

                        @php
                            $correctOptionsCount = $question->options->where('correct', 1)->count();
                        @endphp
                        <input type="hidden" id="correctOptionsCount-{{ $question->id }}"
                            value="{{ $correctOptionsCount }}">

                        @foreach ($question->options as $optIndex => $option)
                            <div class="border p-3 m-2 rounded bg-white border-gray-300">
                                <input class="form-check-input form-checkbox h-5 w-5 text-indigo-600 ml-1 p-2 rounded"
                                    type="checkbox" name="answers[{{ $question->id }}][{{ $optIndex }}]"
                                    id="question-{{ $question->id }}-option-{{ $optIndex }}"
                                    value="{{ $option->id }}" data-question-id="{{ $question->id }}"
                                    onclick="limitCheckboxes({{ $question->id }})">
                                <label class="form-check-label ml-2 text-gray-700"
                                    for="question-{{ $question->id }}-option-{{ $optIndex }}">
                                    {{ $option->option_text }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                @endforeach

                <div class="flex justify-between items-center mt-6 px-6">
                    <a href="{{ Auth::check() ? route('quizzes') : route('welcome') }}"
                        class="px-4 py-2 bg-gray-500 rounded-md text-white hover:bg-gray-600">
                        @lang('messages.back')
                    </a>
                    <div class="space-x-2">
                        <button type="reset" class="px-4 py-2 bg-red-500 rounded-md text-white hover:bg-red-600">
                            @lang('messages.clear')
                        </button>
                        <button type="submit" id="submit-quiz-btn"
                            class="px-4 py-2 bg-blue-500 rounded-md text-white hover:bg-blue-600">
                            @lang('messages.send')
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function limitCheckboxes(questionId) {
            let correctOptionsCount = document.getElementById('correctOptionsCount-' + questionId).value;
            let checkboxes = document.querySelectorAll('input[data-question-id="' + questionId + '"]');
            let checkedCount = 0;

            checkboxes.forEach((checkbox) => {
                if (checkbox.checked) {
                    checkedCount++;
                }
            });

            if (checkedCount >= correctOptionsCount) {
                checkboxes.forEach((checkbox) => {
                    if (!checkbox.checked) {
                        checkbox.disabled = true;
                    }
                });
            } else {
                checkboxes.forEach((checkbox) => {
                    checkbox.disabled = false;
                });
            }
        }
    </script>
</x-app-layout>
