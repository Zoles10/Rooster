<x-app-layout>
    <!-- Very little is needed to make a happy life. - Marcus Aurelius -->
    <div class="bg-gray-800 min-h-screen flex items-center justify-center text-white">
        <div class="max-w-lg w-3/5">
            <h1 class="text-2xl font-bold mb-5 text-center">Create Question</h1>
            <form method="POST" action="{{ route('question.store') }}" class="bg-gray-700 p-6 rounded-lg">
                @csrf
                <div class="mb-4">
                    <label for="question" class="block text-sm font-medium text-gray-300">Question</label>
                    <input type="text" class="form-control mt-1 block w-full px-3 py-2 bg-gray-800 border border-gray-600 rounded-md shadow-sm focus:outline-none focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" id="question" name="question" required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-300">Type of the question</label>
                    <div class="mt-2">
                        <label class="inline-flex items-center">
                            <input type="radio" id="open_ended" name="question_type" value="open_ended" class="form-radio text-indigo-600" required>
                            <span class="ml-2">Open Ended</span>
                        </label>
                        <label class="inline-flex items-center ml-6">
                            <input type="radio" id="multiple_choice" name="question_type" value="multiple_choice" class="form-radio text-indigo-600" required>
                            <span class="ml-2">Multiple Choice</span>
                        </label>
                    </div>
                </div>
                <div class="mb-4">
                    <label for="subject" class="block text-sm font-medium text-gray-300">Subject ID</label>
                    <select id="subject" name="subject" class="form-control mt-1 block w-full px-3 py-2 bg-gray-800 border border-gray-600 rounded-md shadow-sm focus:outline-none focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="">Work in progress</option>
                        <!-- Assuming you have a $subjects array -->
                        {{-- @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                        @endforeach --}}
                    </select>
                </div>
                <div id="options-container" class="mb-4"></div>
                <div class="flex justify-between">
                    <a href="#" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('open_ended').addEventListener('change', handleQuestionTypeChange);
        document.getElementById('multiple_choice').addEventListener('change', handleQuestionTypeChange);

        function handleQuestionTypeChange() {
            var container = document.getElementById('options-container');
            container.innerHTML = ''; // Clear existing inputs
            if (this.value === 'multiple_choice') {
                for (var i = 0; i < 4; i++) {
                    var input = document.createElement('input');
                    input.type = 'text';
                    input.name = 'option' + (i + 1);
                    input.className = 'form-control mt-1 block w-full px-3 py-2 bg-gray-800 border border-gray-600 rounded-md shadow-sm focus:outline-none focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm';
                    container.appendChild(input);
                    var checkbox = document.createElement('input');
                    checkbox.type = 'checkbox';
                    checkbox.name = 'isCorrect' + (i + 1);
                    checkbox.className = 'form-checkbox h-5 w-5 text-indigo-600 mt-3 ml-1';
                    container.appendChild(checkbox);
                }
            }
        }
    </script>
</x-app-layout>
