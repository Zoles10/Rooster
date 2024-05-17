<x-app-layout>
    <div class="bg-white min-h-screen flex flex-col items-center justify-center text-white">
        <div class="imp_margin_04 max-w-xl w-full p-6 md:p-8 bg-gray-500 rounded-lg shadow-lg shadow-gray-400">
            <h1 class="text-2xl font-bold mb-5 text-center">@lang('messages.updateQuestion')</h1>
            <form id="main-form" method="POST"  action="{{ route('question.update', $question) }}" class="bg-gray-500 p-4 rounded-lg">
                @csrf
                @METHOD('PUT')
                <div class="mb-4">
                    <label for="question" class="block text-sm font-medium text-white">@lang('messages.question'):</label>
                    <span id="question-err" class="imp_invalid_input_text" style="display: none;"></span>
                    <input type="text"
                        class="text-black form-control mt-1 block w-full px-3 py-2 bg-white border border-gray-600 rounded-md shadow-sm focus:outline-none focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        id="question" name="question" placeholder="@lang('messages.enterQuestion')"
                        value="{{ $question->question }}">
                </div>
                @if (auth()->user()->isAdmin())
                    <div class="mb-4">
                        <label for="ownerInput" class="block text-sm font-medium text-white">@lang('messages.user'):</label>
                        <select
                            class="text-black form-control mt-1 block w-full px-3 py-2 bg-white border border-gray-600 rounded-md shadow-sm focus:outline-none focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            id="ownerInput" name="ownerInput">
                            <option value="" selected disabled>@lang('messages.selectUser')</option>
                            @foreach ($users as $user)
                                @if ($question->owner_id == $user->id)
                                    <option value="{{ $user->name }}"
                                        @if ($question->owner_id == $user->id) selected @endif>{{ $user->name }}</option>
                                @else
                                    <option value="{{ $user->name }}">{{ $user->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                @endif

                <!-- Subject Dropdown -->
                <div class="mb-4">
                    <label for="subject" class="block text-sm font-medium text-white">@lang('messages.subject'):</label>
                    <span id="subject-err" class="imp_invalid_input_text" style="display: none;"></span>
                    <select id="subject" name="subject"
                        class="text-black form-control mt-1 block w-full px-3 py-2 border border-gray-600 rounded-md shadow-sm focus:outline-none focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @foreach ($subjects as $subject)
                            <option value="{{ $subject->id }}" @if ($question->subject_id == $subject->id) selected @endif>{{ $subject->subject }}</option>
                        @endforeach
                        <option value="0">@lang('messages.other')</option>
                    </select>
                </div>

                <!-- Additional Input Field (Initially Hidden) -->
                <div id="other-subject-container" class="hidden mt-4">
                    <label for="other-subject" class="block text-sm font-medium text-white">@lang('messages.specifySubjectName')</label>
                    <span id="othersubject-err" class="imp_invalid_input_text" style="display: none;"></span>
                    <input type="text" id="other-subject" name="other_subject" placeholder="@lang('messages.subjectName')"
                        class="text-black form-control mt-1 block w-full px-3 py-2 bg-white border border-gray-600 rounded-md shadow-sm focus:outline-none focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>

                @if ($question->question_type === 'open_ended')
                    <div id="result-option-container" class="mb-4 mt-4">
                        <div class="mb-4">
                        <label class="block text-sm font-medium text-white">@lang('messages.resultOption')</label>
                        <div class="mt-3 p-2">
                            <div class="mb-3">
                                <label class="inline-flex items-center">
                                    <input type="radio" id="list" name="word_cloud" value="0"
                                        class="form-radio text-indigo-600" checked>
                                    <span class="ml-2">&nbsp;&nbsp;@lang('messages.list')</span>
                                </label>
                            </div>
                            <div class="mb-3">
                                <label class="inline-flex items-center">
                                    <input type="radio" id="word-cloud" name="word_cloud" value="1"
                                    class="form-radio text-indigo-600">
                                    <span class="ml-2">&nbsp;&nbsp;WordCloud</span>
                                </label>
                            </div>
                        </div>
                    </div>
                @else
                    @php
                        $i = 1;
                    @endphp
                    <!-- Options Container -->
                    <div id="options-container" class="mb-4 mt-4">
                        <label class="block text-sm font-medium text-grey">@lang('messages.correct')</label>
                        @foreach ($question->options as $option)
                            <div id="option-wrapper-{{$i}}" class="flex items-center mb-3">
                                <input type="checkbox" name="isCorrect{{ $i }}" class="form-checkbox imp_checkbox h-5 w-5 text-indigo-600 mt-3 ml-1 p-2 rounded"
                                    @if ($option->correct) checked @endif>
                                <input type="text" name="option{{ $i }}"
                                    class="text-black form-control mt-1 block w-full px-3 py-2 bg-white border border-gray-600 rounded-md shadow-sm focus:outline-none focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    value="{{ $option->option_text }}" placeholder="@lang('messages.optionText')">
                                <button type="button" onclick="deleteOption({{$i}})" class="imp_x_btn">&times;</button>
                            </div>
                            @php
                                $i++;
                            @endphp
                        @endforeach

                        <span id="option-err" class="imp_invalid_input_text" style="display: none;"></span>
                        <!-- Add Option Button with Inline Styles -->
                    </div>
                    <div id="add-option-btn" class="hidden flex justify-center">
                        <button type="button" class="imp_add_btn mt-2 p-2 bg-green-500 rounded-md text-white hover:bg-green-600" onclick="addOption()">
                            @lang('messages.addOption')</button>
                    </div>
                @endif
                <div id="buttonsContainer" class="flex justify-between mt-4">
                    <!-- Cancel Button -->
                    <button type="button" class="imp_bg_orange px-4 py-2 rounded-md text-white hover:bg-gray-600"
                        onclick="resetForm()">@lang('messages.cancel')</button>
                    <!-- Submit Button -->
                    <button type="submit" class="px-4 py-2 imp_bg_purple rounded-md text-white" id="submit-btn">
                        @lang('messages.submit')</button>
                </div>
                @if ($question->question_type === 'multiple_choice')
                    <script>
                        // Get a reference to the form and the options-container
                        const form = document.getElementById('main-form');
                        const optionsContainer = document.getElementById('options-container');
                        // Remove the options-container from its current parent node
                        optionsContainer.parentNode.removeChild(optionsContainer);
                        // Append the options-container to the form
                        form.appendChild(optionsContainer);
                        form.appendChild(document.getElementById('add-option-btn'));
                        form.appendChild(document.getElementById('buttonsContainer'));
                        // Show the "Add Option" button when the page loads
                        document.getElementById('add-option-btn').classList.remove('hidden');
                    </script>
                @endif
            </form>
        </div>
        <div id="back-btn" class="bg-blue-700 mt-3 px-4 py-2 rounded-md text-white hover:bg-gray-600">
            <a href={{ route('question.index') }}>@lang('messages.backToQuestions')</a>
        </div>
        @if ($question->question_type === 'open_ended')
            <script>
                const backBtn = document.getElementById('back-btn');
                backBtn.parentNode.removeChild(backBtn);
                document.getElementById('main-form').parentNode.parentNode.appendChild(backBtn);
            </script>
        @endif
    </div>

    <script>
        let optionCount = {{ count($question->options) }};

        // Update the option count and option ids
        optionCount = {{ count($question->options) }};
        for (var i = 1; i <= optionCount; i++) {
            var currentOptionWrapper = document.getElementById('option-wrapper-' + i);
            var currentOptionInput = currentOptionWrapper.querySelector('input[name^="option"]');
            var currentCheckboxInput = currentOptionWrapper.querySelector('input[name^="isCorrect"]');
            currentOptionInput.name = 'option' + i;
            currentCheckboxInput.name = 'isCorrect' + i;
            currentOptionWrapper.id = 'option-wrapper-' + i;
        }

        // Function to Delete an Option
        function deleteOption(optionNumber) {
            var optionWrapper = document.getElementById('option-wrapper-' + optionNumber);
            optionWrapper.parentNode.removeChild(optionWrapper);
            // Update the option count
            optionCount--;
            // Update the remaining option ids
            for (var i = optionNumber + 1; i <= optionCount+1; i++) {
                var currentOptionWrapper = document.getElementById('option-wrapper-' + i);
                var currentOptionInput = currentOptionWrapper.querySelector('input[name^="option'+i+'"]');
                var currentCheckboxInput = currentOptionWrapper.querySelector('input[name^="isCorrect'+i+'"]');
                currentOptionInput.name = 'option' + (i - 1);
                currentCheckboxInput.name = 'isCorrect' + (i - 1);
                currentOptionWrapper.id = 'option-wrapper-' + (i - 1);
            }
        }

        // Function to Add More Options Dynamically
        function addOption(optionNumber = null) {
            var container = document.getElementById('options-container');

            // Create a new input field for the option
            var input = document.createElement('input');
            input.type = 'text';
            input.name = 'option' + (optionNumber || ++optionCount);
            input.placeholder = '@lang('messages.optionText')';
            input.className =
                'form-control mt-1 block w-full px-3 py-2 bg-white border border-gray-600 rounded-md shadow-sm focus:outline-none focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm';
            input.style = 'color: black;'
            // Create a new checkbox for correct option
            var checkbox = document.createElement('input');
            checkbox.type = 'checkbox';
            checkbox.name = 'isCorrect' + (optionNumber || optionCount);
            checkbox.className = 'form-checkbox h-5 w-5 text-indigo-600 mt-3 ml-1 p-2 rounded';
            checkbox.style = 'margin: .25rem 2.7rem 0 .8rem; border-radius: 4px;'

            // Add a red "Remove" button
            var removeButton = document.createElement('button');
            removeButton.type = 'button';
            removeButton.innerHTML = '&times;';
            removeButton.style =
                'background-color: red; margin-top: .25rem; color: #f2f2f2; border-radius: 4px; padding: 8px; margin-left: 8px; line-height: .7;';
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

        function resetForm() {
            window.location.reload(); // Refresh the window
        }

        function handleSubmit(event) {
            event.preventDefault(); // Prevent default form submission

            // Form validation
            const questionInput = document.getElementById('question');
            const subjectDropdown = document.getElementById('subject');

            if (questionInput.value.trim() === '') {
                let questionErr = document.getElementById('question-err')
                questionErr.innerHTML = 'Enter question text'
                questionErr.style.display = 'block'
                return;
            } else {
                let questionErr = document.getElementById('question-err')
                questionErr.style.display = 'none'
            }

            if (subjectDropdown.value === '0') {
                const otherSubjectInput = document.getElementById('other-subject');
                if (otherSubjectInput.value.trim() === '') {
                    let othersubjectErr = document.getElementById('othersubject-err');
                    othersubjectErr.innerHTML = 'Enter subject name'
                    othersubjectErr.style.display = 'block'
                    return;
                } else {
                    let othersubjectErr = document.getElementById('othersubject-err');
                    othersubjectErr.style.display = 'none'
                }
            }

            // Additional validation for multiple choice questions
            const questionType = document.querySelector('input[name="question_type"]:checked');
            if (questionType && questionType.value === 'multiple_choice') {
                const options = document.querySelectorAll('input[name^="option"]');
                let allValid = true;
                let optionErr = document.getElementById('option-err');

                options.forEach(option => {
                    if (option.value.trim() === '') {
                        // Mark options as invalid if any option is empty
                        allValid = false;
                    }
                });
                if (!allValid) {
                    optionErr.innerHTML = 'Option text is empty';
                    optionErr.style.display = 'block';
                    return;
                } else {
                    // Hide the error message if everything is valid
                    optionErr.style.display = 'none';
                }
            }


            // Submit the form after validation
            document.getElementById('main-form').submit();
        }

        // Attach the `handleSubmit` function to the submit button
        document.getElementById('submit-btn').addEventListener('click', handleSubmit);
    </script>
</x-app-layout>
