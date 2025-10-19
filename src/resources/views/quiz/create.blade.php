<x-app-layout>
    <div class="min-h-screen w-full bg-gray-100 py-6">
        <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-2xl font-bold mb-6 text-center text-gray-900">@lang('messages.createQuiz')</h1>

            <form id="main-form" method="POST" action="{{ route('quiz.store') }}" class="">
                @csrf
                <div class="bg-white p-6 rounded-lg shadow center">
                    <!-- QUIZ FORMULAR -->
                    <div>
                        <div class="mb-4">
                            <label for="quiz"
                                class="block text-sm font-medium text-gray-700">@lang('messages.quiz'):</label>
                            <span id="quiz-err" class="imp_invalid_input_text text-sm text-red-600"
                                style="display: none;"></span>
                            <input type="text"
                                class="mt-1 block w-full px-3 py-2 text-black bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                id="quiz" name="quiz" placeholder="@lang('messages.enterQuiz')"
                                value="{{ old('quiz') }}">
                        </div>

                        <div class="mb-4">
                            <label for="quizDescription"
                                class="block text-sm font-medium text-gray-700">@lang('messages.quizDescription'):</label>
                            <span id="quizDescription-err" class="imp_invalid_input_text text-sm text-red-600"
                                style="display: none;"></span>
                            <input type="text"
                                class="mt-1 block w-full px-3 py-2 text-black bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                id="quizDescription" name="quizDescription" placeholder="@lang('messages.enterQuizDescription')"
                                value="{{ old('quizDescription') }}">
                        </div>

                        @if (auth()->user()->isAdmin())
                            <div class="mb-4">
                                <label for="ownerInput"
                                    class="block text-sm font-medium text-gray-700">@lang('messages.user'):</label>
                                <select id="ownerInput" name="ownerInput"
                                    class="mt-1 block w-full px-3 py-2 bg-white text-black border border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="" selected disabled>@lang('messages.selectUser')</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->name }}"
                                            @if (old('ownerInput', auth()->user()->name) == $user->name) selected @endif>{{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                    </div>
                    <!-- AVAILABLE QUESTIONS FORMULAR -->
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-lg font-semibold text-gray-800">@lang('messages.availableQuestions')</h2>
                        </div>
                        <div id="selected-questions-inputs">
                            @php
                                $selected = (array) old('selected_questions', []);
                            @endphp
                            @foreach ($selected as $selId)
                                @if ($selId !== null && $selId !== '')
                                    <input type="hidden" name="selected_questions[]" value="{{ $selId }}"
                                        data-selected-input="{{ $selId }}">
                                @endif
                            @endforeach
                        </div>

                        <div class="flex-1 overflow-auto border rounded p-2">
                            @php
                                $selected = (array) old('selected_questions', []);
                            @endphp

                            @if (isset($questions) && $questions->count())
                                <ul id="available-list" class="space-y-2">
                                    @foreach ($questions as $question)
                                        @php $isSelected = in_array($question->id, $selected); @endphp
                                        <li class="flex items-start justify-between bg-gray-50 p-2 rounded available-item"
                                            data-id="{{ $question->id }}"
                                            data-question="{{ e(\Illuminate\Support\Str::limit($question->question)) }}">
                                            <div class="flex items-start">
                                                <label class="text-sm text-gray-800">
                                                    <strong>{{ \Illuminate\Support\Str::limit($question->question) }}</strong>
                                                </label>
                                            </div>

                                            <button type="button"
                                                class="toggle-btn text-xs px-2 py-1 rounded
                                                @if ($isSelected) bg-red-600 text-white remove-state
                                                @else bg-indigo-600 text-white add-state @endif"
                                                data-id="{{ $question->id }}"
                                                data-selected="{{ $isSelected ? '1' : '0' }}"
                                                data-add-label="@lang('messages.add')"
                                                data-remove-label="@lang('messages.remove')">
                                                @if ($isSelected)
                                                    @lang('messages.remove')
                                                @else
                                                    @lang('messages.add')
                                                @endif
                                            </button>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <div class="text-sm text-gray-600">@lang('messages.noQuestionsAvailable')</div>
                            @endif
                        </div>
                    </div>
                    <!-- BUTTONS FOR FORMULAR -->
                    <div>
                        <button id="add-all-questions" type="button"
                            class="px-4 py-2 bg-gray-500 text-white rounded-md">@lang('messages.addAll')</button>

                        <button id="clear-selection" type="button"
                            class="px-4 py-2 bg-gray-500 text-white rounded-md">@lang('messages.clear')</button>

                        <div class="flex justify-between items-center mt-6">
                            <a href="{{ route('quizzes') }}"
                                class="inline-block px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400">@lang('messages.backToQuizzes')</a>
                            <button type="submit" id="submit-btn"
                                class="px-4 py-2 imp_bg_purple text-white rounded-md">@lang('messages.submit')</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @vite('resources/js/createQuestion.js')
</x-app-layout>
