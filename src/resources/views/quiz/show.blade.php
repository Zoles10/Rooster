@section('title', __('messages.quizShow'))
<x-app-layout>
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-md">
            <div class="imp_bg_white p-6">
                <h1 class="text-2xl font-bold text-gray-900">{{ $quiz->title }}</h1>
                <p class="text-gray-600 mt-2">{{ $quiz->description }}</p>
            </div>

            <form id="quiz-answer-form" action="{{ route('quiz.submitAnswers', $quiz->id) }}" method="POST" class="p-6">
                @csrf

                @foreach ($quiz->questions as $index => $question)
                    <div class="mb-8 p-6 bg-gray-50 rounded-md border border-gray-200">
                        <h4 class="text-xl mb-4 font-semibold text-gray-800">{{ $index + 1 }}.
                            {{ $question->question }}</h4>

                        @php
                            $correctOptionsCount = $question->options->where('correct', 1)->count();
                        @endphp
                        <input type="hidden" id="correctOptionsCount-{{ $question->id }}"
                            value="{{ $correctOptionsCount }}">

                        @foreach ($question->options as $optIndex => $option)
                            <div
                                class="border p-4 m-2 rounded bg-white border-gray-300 hover:border-indigo-300 transition ease-in-out duration-150">
                                <input
                                    class="form-check-input form-checkbox h-5 w-5 text-indigo-400 hover:text-indigo-600 ml-1 p-2 rounded cursor-pointer"
                                    type="checkbox" name="answers[{{ $question->id }}][{{ $optIndex }}]"
                                    id="question-{{ $question->id }}-option-{{ $optIndex }}"
                                    value="{{ $option->id }}" data-question-id="{{ $question->id }}"
                                    onclick="limitCheckboxes({{ $question->id }})">
                                <label class="form-check-label ml-2 text-gray-700 cursor-pointer"
                                    for="question-{{ $question->id }}-option-{{ $optIndex }}">
                                    {{ $option->option_text }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                @endforeach

                <div
                    class="flex flex-col sm:flex-row gap-4 justify-between items-start sm:items-center pt-6 border-t border-gray-200">
                    <a href="{{ Auth::check() ? route('quizzes') : route('welcome') }}"
                        class="inline-flex items-center justify-center px-4 py-2 bg-gray-500 hover:bg-gray-700 text-white rounded-md border border-transparent focus:outline-none transition ease-in-out duration-150">
                        @svg('mdi-arrow-left', 'w-5 h-5 mr-2')
                        @lang('messages.back')
                    </a>
                    <div class="flex gap-2">
                        <button type="reset"
                            class="inline-flex items-center justify-center px-4 py-2 bg-rose-500 hover:bg-rose-600 text-white rounded-md border border-transparent focus:outline-none transition ease-in-out duration-150">
                            @svg('mdi-refresh', 'w-5 h-5 mr-2')
                            @lang('messages.clear')
                        </button>
                        <button type="submit" id="submit-quiz-btn"
                            class="inline-flex items-center justify-center px-4 py-2 bg-indigo-500 hover:bg-indigo-600 text-white rounded-md border border-transparent focus:outline-none transition ease-in-out duration-150">
                            @svg('mdi-send', 'w-5 h-5 mr-2')
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
