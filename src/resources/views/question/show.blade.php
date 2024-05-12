<x-app-layout>
    <div class="container mx-auto my-5 p-5">
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-xl mb-3">{{ $question->question }}</h2>
            @if (Auth::id() == $question->owner_id)
                <h2 class="text-xl mb-3">User viewing is the owner</h2>
            @endif
            <form id="answer-form" action="{{ route('answer.store') }}" method="POST">
                @csrf
                <input type="hidden" name="question_id" value="{{ $question->id }}">

                @if ($question->question_type == 'open_ended')
                    <div>
                        <label for="user_text" class="block text-sm font-medium text-gray-700">Your Answer:</label>
                        <span id="answer-err" style="display: none; font-size: .7rem; color:red;"></span>
                        <input type="text" id="user_text" name="user_text"
                            class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                @else
                    @php
                        $correctOptionsCount = $question->options->where('correct', 1)->count();
                    @endphp
                    <input type="hidden" id="correctOptionsCount" value="{{ $correctOptionsCount }}">
                    @foreach ($question->options as $index => $option)
                        <div class="border p-3 m-2 rounded bg-light">
                            <input class="form-check-input" type="checkbox" name="selected{{ $index + 1 }}"
                                id="option{{ $index + 1 }}" value="{{ $option->option_text }}"
                                onclick="limitCheckboxes()">
                            <label class="form-check-label" for="option{{ $index + 1 }}">
                                {{ $option->option_text }}
                            </label>
                        </div>
                    @endforeach
                @endif

                <button type="button" id="submit-btn" class="mt-2 mr-2 px-4 py-2 bg-blue-500 rounded-md text-white hover:bg-blue-600">Send</button>
                <button type="reset" class="mt-2 mr-2 px-4 py-2 bg-red-500 rounded-md text-white hover:bg-red-600">Clear</button>
                <a href="/" class="inline-block px-4 py-2 bg-green-500 rounded-md text-white hover:bg-green-600">Back</a>
            </form>
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


            if (answerInput.value.trim() === '') {
                let answerErr = document.getElementById('answer-err')
                answerErr.innerHTML = 'Enter answer text'
                answerErr.style.display = 'block'
                return;
            } else {
                let answerErr = document.getElementById('answer-err')
                answerErr.style.display = 'none'
            }
            document.getElementById('answer-form').submit();
        }


        // Submit the form after validation


        // Attach the `handleSubmit` function to the submit button
        document.getElementById('submit-btn').addEventListener('click', handleSubmit);
    </script>
</x-app-layout>
