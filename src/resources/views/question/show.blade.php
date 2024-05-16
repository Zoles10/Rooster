<x-app-layout>
    <div class="container mx-auto my-5 p-5">
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-xl mb-3">{{ $question->question }}</h2>
            <form id="answer-form" action="{{ route('answer.store', ['id' => $question->id]) }}" method="POST">
                @csrf
                @if ($question->question_type == 'open_ended')
                    <div>
                        <label for="user_text" class="block text-sm font-medium text-gray-700">@lang('messages.yourAnswer'):</label>
                        <span id="answer-err" class="imp_answer_err"></span>
                        <input type="text" id="user_text" name="user_text"
                            class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                @else
                    @php
                        $correctOptionsCount = $question->options->where('correct', 1)->count();
                    @endphp
                    <input type="hidden" id="correctOptionsCount" value="{{ $correctOptionsCount }}">
                    @foreach ($question->options as $index => $option)
                        <div class="border p-3 m-2 rounded bg-light border-violet-600">
                            <input class="form-check-input form-checkbox h-5 w-5 text-indigo-600 ml-1 p-2 rounded " type="checkbox" name="selected{{ $index + 1 }}"
                                id="option{{ $index + 1 }}" value="{{ $option->option_text }}"
                                onclick="limitCheckboxes()">
                            <label class="form-check-label ml-1 mt-1" for="option{{ $index + 1 }}">
                                {{ $option->option_text }}
                            </label>
                        </div>
                    @endforeach
                @endif
                @method("POST")
                <button type="submit" id="submit-btn" class="mt-2 mr-2 px-4 py-2 bg-blue-500 rounded-md text-white hover:bg-blue-600">@lang('messages.send')</button>
                <button type="reset" class="mt-2 mr-2 px-4 py-2 bg-red-500 rounded-md text-white hover:bg-red-600">@lang('messages.clear')</button>
                <a href="/" class="inline-block px-4 py-2 bg-green-500 rounded-md text-white hover:bg-green-600">@lang('messages.back')</a>
            </form>
            @if (Auth::id() == $question->owner_id)
                @include("question.ownerShow")
            @endif
        </div>
    </div>
    <script>
        function limitCheckboxes() {
            let correctOptionsCount = document.getElementById('correctOptionsCount').value;
            let checkedCount = document.querySelectorAll('input[type="checkbox"]:checked').length;
            let checkboxes = document.querySelectorAll('input[type="checkbox"]');
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

        function handleSubmit(event) {
            event.preventDefault(); // Prevent default form submission
            console.log("ide");
            const answerInput = document.getElementById('user_text');

            if (answerInput) {
                if (answerInput.value.trim() === '') {
                    let answerErr = document.getElementById('answer-err')
                    answerErr.innerHTML = 'Enter answer text'
                    answerErr.style.display = 'block'
                    return;
                } else {
                    let answerErr = document.getElementById('answer-err')
                    answerErr.style.display = 'none'
                }
            }
            document.getElementById('answer-form').submit();
        }
        // Attach the `handleSubmit` function to the submit button
        document.getElementById('submit-btn').addEventListener('click', handleSubmit);
    </script>
</x-app-layout>
