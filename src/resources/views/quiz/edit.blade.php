@section('title', __('messages.editQuiz'))
<x-app-layout>
    @vite('resources/js/createQuiz.js')
    <script>
        window.quizValidationMessages = {
            quizTitleRequired: "{{ __('messages.quizTitleRequired') }}",
            quizDescriptionRequired: "{{ __('messages.quizDescriptionRequired') }}",
            atLeastOneQuestionRequired: "{{ __('messages.atLeastOneQuestionRequired') }}"
        };
    </script>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('messages.editQuiz') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-md">
            <div class="imp_bg_white p-6">
                <h1 class="text-2xl font-bold text-gray-900">{{ __('messages.quiz') }}</h1>
            </div>

            <form id="main-form" method="POST" action="{{ route('quiz.update', $quiz) }}">
                @csrf
                @method('PUT')
                <div class="bg-white p-6 rounded-md shadow center">
                    <!-- QUIZ FORMULAR -->
                    <div>
                        <div class="mb-4">
                            <label for="quiz"
                                class="block text-sm font-medium text-gray-700">@lang('messages.quiz_title'):</label>
                            <span id="quiz-err" class="imp_invalid_input_text text-sm text-red-600 hidden"></span>
                            <input type="text"
                                class="mt-1 block w-full px-3 py-2 text-black bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                id="quiz" name="quiz" placeholder="@lang('messages.enterQuiz')"
                                value="{{ $quiz->title }}">
                        </div>

                        <div class="mb-4">
                            <label for="quizDescription"
                                class="block text-sm font-medium text-gray-700">@lang('messages.quizDescription'):</label>
                            <span id="quizDescription-err"
                                class="imp_invalid_input_text text-sm text-red-600 hidden"></span>
                            <input type="text"
                                class="mt-1 block w-full px-3 py-2 text-black bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                id="quizDescription" name="quizDescription" placeholder="@lang('messages.enterQuizDescription')"
                                value="{{ $quiz->description }}">
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
                                            @if (old('ownerInput', $quiz->owner->name ?? auth()->user()->name) == $user->name) selected @endif>{{ $user->name }}
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
                                $selected = (array) old('selected_questions', $quiz->questions->pluck('id')->toArray());
                            @endphp
                            @foreach ($selected as $selId)
                                @if ($selId !== null && $selId !== '')
                                    <input type="hidden" name="selected_questions[]" value="{{ $selId }}"
                                        data-selected-input="{{ $selId }}">
                                @endif
                            @endforeach
                        </div>

                        <div class="flex-1 border rounded p-2">
                            @php
                                $selected = (array) old('selected_questions', $quiz->questions->pluck('id')->toArray());
                            @endphp

                            @if (isset($questions) && $questions->count())
                                <ul id="available-list" class="space-y-2">
                                    @foreach ($questions as $question)
                                        @php $isSelected = in_array($question->id, $selected); @endphp
                                        <li class="flex items-start justify-between bg-gray-50 p-2 rounded available-item question-item"
                                            data-id="{{ $question->id }}"
                                            data-question="{{ e(\Illuminate\Support\Str::limit($question->question)) }}">
                                            <div class="flex items-start">
                                                <label class="text-sm text-gray-800">
                                                    <strong>{{ \Illuminate\Support\Str::limit($question->question) }}</strong>
                                                </label>
                                            </div>

                                            <button type="button"
                                                class="toggle-btn inline-flex items-center justify-center w-7 h-7 rounded-md border border-transparent focus:outline-none transition ease-in-out duration-150
                                                @if ($isSelected) bg-rose-500 hover:bg-rose-600 text-white
                                                @else bg-indigo-500 hover:bg-indigo-600 text-white @endif"
                                                data-id="{{ $question->id }}"
                                                data-selected="{{ $isSelected ? '1' : '0' }}"
                                                data-add-label="@lang('messages.add')"
                                                data-remove-label="@lang('messages.remove')">
                                                @if ($isSelected)
                                                    @svg('mdi-minus', 'w-4 h-4')
                                                @else
                                                    @svg('mdi-plus', 'w-4 h-4')
                                                @endif
                                            </button>
                                        </li>
                                    @endforeach
                                </ul>

                                <div id="pagination-controls" class="mt-4 flex justify-end">
                                    <span class="relative z-0 inline-flex rtl:flex-row-reverse shadow-sm rounded-md">
                                        <button type="button" id="prev-page"
                                            class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-l-md leading-5 hover:text-gray-400 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150 disabled:opacity-50 disabled:cursor-default disabled:hover:text-gray-500">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                        <span id="page-info"
                                            class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5"></span>
                                        <button type="button" id="next-page"
                                            class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-r-md leading-5 hover:text-gray-400 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150 disabled:opacity-50 disabled:cursor-default disabled:hover:text-gray-500">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </span>
                                </div>
                            @else
                                <div class="text-sm text-gray-600">@lang('messages.noQuestionsAvailable')</div>
                            @endif
                        </div>
                        <span id="question-selection-err" class="text-sm text-red-600 border-none hidden"></span>
                    </div>
                    <!-- BUTTONS FOR FORMULAR -->
                    <div class="flex flex-col sm:flex-row gap-4 justify-between items-start sm:items-center pt-6">
                        <div class="flex flex-wrap gap-2">
                            <button id="add-all-questions" type="button"
                                class="inline-flex items-center justify-center px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white rounded-md border border-transparent focus:outline-none transition ease-in-out duration-150">
                                @svg('mdi-plus-box-multiple', 'w-5 h-5 mr-2')
                                @lang('messages.addAll')
                            </button>

                            <button id="clear-selection" type="button"
                                class="inline-flex items-center justify-center px-4 py-2 bg-rose-500 hover:bg-rose-600 text-white rounded-md border border-transparent focus:outline-none transition ease-in-out duration-150">
                                @svg('mdi-refresh', 'w-5 h-5 mr-2')
                                @lang('messages.clear')
                            </button>
                        </div>

                        <div class="flex gap-2">
                            <a href="{{ route('quizzes') }}"
                                class="inline-flex items-center justify-center px-4 py-2 bg-gray-500 hover:bg-gray-700 text-white rounded-md border border-transparent focus:outline-none transition ease-in-out duration-150">
                                @svg('mdi-arrow-left', 'w-5 h-5 mr-2')
                                @lang('messages.backToQuizzes')
                            </a>
                            <button type="submit" id="submit-btn"
                                class="inline-flex items-center justify-center px-4 py-2 bg-indigo-500 hover:bg-indigo-600 text-white rounded-md border border-transparent focus:outline-none transition ease-in-out duration-150">
                                @svg('mdi-content-save', 'w-5 h-5 mr-2')
                                @lang('messages.submit')
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
