<x-app-layout>
    <div class="container mx-auto my-5 p-5">
        <div class="text-center">
            {{-- <h1 class="text-3xl mb-4">Question: {{ $question->created_at}}</h1> --}}
            {{-- <div class="mb-5">
                <a href="{{ route('question.edit', $question)}}" class="btn btn-primary mr-2">Edit</a>
                <form action="{{ route('question.destroy', $question) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger">Delete</button>
                </form>
            </div> --}}
        </div>
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-xl mb-3">{{ $question->question}}</h2>
            @if($question->question_type == 'open_ended')
                <div>
                    <label for="answer" class="block text-sm font-medium text-gray-700">Your Answer:</label>
                    <input type="text" id="answer" name="answer" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
            @elseif($question->question_type == 'multiple_choice')
                @foreach($question->options as $option)
                    <div class="border p-3 m-2 rounded bg-light option-box" onclick="handleOptionClick(this)">
                        {{ $option->option_text }}
                    </div>
                @endforeach
            @endif
        </div>
        <!-- Send Button -->
        <button id="send-btn" type="button" class="px-4 py-2 bg-blue-500 rounded-md text-white hover:bg-blue-600">Send</button>

        <!-- Clear Button -->
        <button id="clear-btn" type="button" class="px-4 py-2 bg-red-500 rounded-md text-white hover:bg-red-600">Clear</button>
    </div>

    <script>
        let clickCount = 0;
        const correctAnswers = {{ $question->options->where('correct', 1)->count() }};

        function handleOptionClick(element) {
            if (clickCount < correctAnswers) {
                element.style.backgroundColor = 'lightblue';
                element.classList.add('selected'); // Add 'selected' class to clicked box
                clickCount++;
            }
        }

        document.getElementById('send-btn').addEventListener('click', function() {
            // Get all selected boxes
            var selectedBoxes = document.querySelectorAll('.option-box.selected');
            var answers = [];
            selectedBoxes.forEach(function(box) {
                answers.push(box.textContent.trim()); // Add box text to answers array
            });

            // Send answers and question id
            var questionId = {{ $question->id }};
            sendAnswers(answers, questionId);
        });

        document.getElementById('clear-btn').addEventListener('click', function() {
            resetBoxes();
        });

        function resetBoxes() {
            // Get all boxes
            var boxes = document.getElementsByClassName('box');

            // Loop through all boxes and reset their state
            for (var i = 0; i < boxes.length; i++) {
                boxes[i].style.backgroundColor = 'normal'; // Reset color
                boxes[i].dataset.clicks = 0; // Reset clicks
            }
        }

        function sendAnswers(answers, questionId) {
            // Add your send functionality here
            // You now have an array of answers and the question id
        }
    </script>
</x-app-layout>
