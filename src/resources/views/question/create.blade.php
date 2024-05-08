<x-app-layout>
    <div class="bg-white min-h-screen flex items-center justify-center text-white">
        <div class="max-w-xl w-full p-6 md:p-8 bg-gray-500 rounded-lg shadow-lg" style="margin: 0 .4rem;">
            <h1 class="text-2xl font-bold mb-5 text-center">Create Question</h1>
            <form method="POST" action="{{ route('question.store') }}" class="bg-gray-500 p-6 rounded-lg">
                @csrf
                <div class="mb-4">
                    <label for="question" class="block text-sm font-medium text-white">Question:</label>
                    <input type="text"
                        class="form-control mt-1 block w-full px-3 py-2 bg-white border border-gray-600 rounded-md shadow-sm focus:outline-none focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        id="question" name="question" required style="color: rgb(15, 15, 15);">
                </div>

                <!-- Type of Question -->
                <div class="">
                    <label class="block text-sm font-medium text-white">Type of the question:</label>
                    <div class="mt-3 p-2">
                        <div class="mb-3">
                            <label class="inline-flex items-center">
                                <input type="radio" id="open_ended" name="question_type" value="open_ended"
                                    class="form-radio text-indigo-600" required>
                                <span class="ml-2">&nbsp;&nbsp;Open Ended</span>
                            </label>
                        </div>
                        <div class="mb-3">
                            <label class="inline-flex items-center">
                                <input type="radio" id="multiple_choice" name="question_type" value="multiple_choice"
                                    class="form-radio text-indigo-600" required>
                                <span class="ml-2">&nbsp;&nbsp;Multiple Choice</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Subject Dropdown -->
                <div class="mb-4">
                    <label for="subject" class="block text-sm font-medium text-white">Subject:</label>
                    <select id="subject" name="subject"
                        class="form-control mt-1 block w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md shadow-sm focus:outline-none focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="1" selected>Work in progress</option>
                        <option value="0">Other</option>
                    </select>
                </div>

                <!-- Additional Input Field (Initially Hidden) -->
                <div id="other-subject-container" class="hidden mt-4">
                    <label for="other-subject" class="block text-sm font-medium text-white">Specify subject name:</label>
                    <input type="text" id="other-subject" name="other_subject"
                        class="form-control mt-1 block w-full px-3 py-2 bg-gray-500 border border-gray-600 rounded-md shadow-sm focus:outline-none focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>

                <!-- Options Container -->
                <div id="options-container" class="mb-4 mt-4">

                </div>

                <!-- Add Option Button with Inline Styles -->
                <div id="add-option-btn" class="hidden flex justify-center">
                    <button type="button" class="mt-2 p-2 bg-green-500 rounded-md text-white hover:bg-green-600"
                            style="background-color: green; color: white; border-radius: 4px;"
                            onclick="addOption()">Add Option</button>
                </div>

                <div class="flex justify-between mt-4">
                    <a href="#" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Event Listeners for Question Type Selection
        document.getElementById('open_ended').addEventListener('change', handleQuestionTypeChange);
        document.getElementById('multiple_choice').addEventListener('change', handleQuestionTypeChange);

        // Initial Option Counter
        let optionCount = 4;

        // Handles the Change Between Open Ended and Multiple Choice
        function handleQuestionTypeChange() {
            var container = document.getElementById('options-container');
            container.innerHTML = '<label class="block text-sm font-medium text-grey">Correct:</label>'; // Clear existing inputs
            var addOptionBtn = document.getElementById('add-option-btn');
            optionCount = 4; // Reset to the default number of options

            if (this.value === 'multiple_choice') {
                addOptionBtn.classList.remove('hidden'); // Show "Add Option" button

                // Add default 4 options
                for (var i = 0; i < optionCount; i++) {
                    addOption(i + 1);
                }
            } else {
                addOptionBtn.classList.add('hidden'); // Hide "Add Option" button
            }
        }

        // Function to Add More Options Dynamically
        function addOption(optionNumber = null) {
            var container = document.getElementById('options-container');

            // Create a new input field for the option
            var input = document.createElement('input');
            input.type = 'text';
            input.name = 'option' + (optionNumber || ++optionCount);
            input.placeholder = 'Option text';
            input.className =
                'form-control mt-1 block w-full px-3 py-2 bg-white border border-gray-600 rounded-md shadow-sm focus:outline-none focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm';

            // Create a new checkbox for correct option
            var checkbox = document.createElement('input');
            checkbox.type = 'checkbox';
            checkbox.name = 'isCorrect' + (optionNumber || optionCount);
            checkbox.className = 'form-checkbox h-5 w-5 text-indigo-600 mt-3 ml-1 p-2';
            checkbox.style = 'margin: .25rem 2.5rem 0 .8rem; border-radius: 4px;'

            // Add a red "Remove" button
            var removeButton = document.createElement('button');
            removeButton.type = 'button';
            removeButton.innerHTML = '&times;';
            removeButton.style = 'background-color: red; margin-top: .25rem; color: #f2f2f2; border-radius: 4px; padding: 8px; margin-left: 8px; line-height: .7;';
            removeButton.onclick = function() {
                container.removeChild(optionWrapper);
            };

            // Wrap the inputs together
            var optionWrapper = document.createElement('div');
            optionWrapper.className = 'flex items-center mb-3';
            optionWrapper.appendChild(checkbox);
            optionWrapper.appendChild(input);
            optionWrapper.appendChild(removeButton);

            container.appendChild(optionWrapper);
        }

        // Toggle visibility of the "Other" input field based on subject dropdown
        const subjectDropdown = document.getElementById('subject');
        const otherSubjectContainer = document.getElementById('other-subject-container');

        subjectDropdown.addEventListener('change', function() {
            if (this.value === '0') {
                otherSubjectContainer.classList.remove('hidden');
            } else {
                otherSubjectContainer.classList.add('hidden');
            }
        });
    </script>
</x-app-layout>
