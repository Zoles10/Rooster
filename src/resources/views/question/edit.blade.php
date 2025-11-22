<x-app-layout>
    <div class="bg-white min-h-screen flex flex-col items-center justify-center text-white">
        <div
            class="imp_margin_04 max-w-xl w-full p-6 md:p-8 bg-gray-100 rounded-lg shadow-lg shadow-gray-400 text-black">
            <h1 class="text-2xl font-bold mb-5 text-center">@lang('messages.updateQuestion')</h1>
            <form id="main-form" method="POST" action="{{ route('question.update', $question) }}"
                class="bg-gray-100 p-4 rounded-lg text-black">
                @csrf
                @METHOD('PUT')
                <div class="mb-4">
                    <label for="question" class="block text-sm font-medium text-black">@lang('messages.question'):</label>
                    <span id="question-err" class="imp_invalid_input_text" style="display: none;"></span>
                    <input type="text"
                        class="text-black form-control mt-1 block w-full px-3 py-2 bg-white border border-gray-600 rounded-md shadow-sm focus:outline-none focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        id="question" name="question" placeholder="@lang('messages.enterQuestion')"
                        value="{{ $question->question }}">
                </div>
                @if (auth()->user()->isAdmin())
                    <div class="mb-4">
                        <label for="ownerInput" class="block text-sm font-medium text-black">@lang('messages.user'):</label>
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
                    <label for="subject" class="block text-sm font-medium text-black">@lang('messages.subject'):</label>
                    <span id="subject-err" class="imp_invalid_input_text" style="display: none;"></span>
                    <select id="subject" name="subject"
                        class="text-black form-control mt-1 block w-full px-3 py-2 border border-gray-600 rounded-md shadow-sm focus:outline-none focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @foreach ($subjects as $subject)
                            <option value="{{ $subject->id }}" @if ($question->subject_id == $subject->id) selected @endif>
                                {{ $subject->subject }}</option>
                        @endforeach
                        <option value="0">@lang('messages.other')</option>
                    </select>
                </div>

                <!-- Additional Input Field (Initially Hidden) -->
                <div id="other-subject-container" class="hidden mt-4">
                    <label for="other-subject" class="block text-sm font-medium text-black">@lang('messages.specifySubjectName')</label>
                    <span id="othersubject-err" class="imp_invalid_input_text" style="display: none;"></span>
                    <input type="text" id="other-subject" name="other_subject" placeholder="@lang('messages.subjectName')"
                        class="text-black form-control mt-1 block w-full px-3 py-2 bg-white border border-gray-600 rounded-md shadow-sm focus:outline-none focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>

                @php
                    $i = 1;
                @endphp
                <!-- Options Container -->
                <div id="options-container" class="mb-4 mt-4" data-initial-count="{{ $question->options->count() }}">
                    <label class="block text-sm font-medium text-black">@lang('messages.correct')</label>
                    @foreach ($question->options as $option)
                        <div id="option-wrapper-{{ $i }}" class="flex items-center mb-3">
                            <input type="checkbox" name="isCorrect{{ $i }}"
                                class="form-checkbox imp_checkbox h-5 w-5 text-indigo-600 mt-3 ml-1 p-2 rounded hover:text-indigo-700 cursor-pointer"
                                @if ($option->correct) checked @endif>
                            <input type="text" name="option{{ $i }}"
                                class="text-black form-control mt-1 block w-full px-3 py-2 bg-white border border-gray-600 rounded-md shadow-sm focus:outline-none focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                value="{{ $option->option_text }}" placeholder="@lang('messages.optionText')">
                            <button type="button" onclick="deleteOption({{ $i }})"
                                class="imp_x_btn bg-rose-500 hover:bg-rose-600">&times;</button>
                        </div>
                        @php
                            $i++;
                        @endphp
                    @endforeach

                    <span id="option-err" class="imp_invalid_input_text" style="display: none;"></span>
                    <!-- Add Option Button with Inline Styles -->
                </div>
                <div id="add-option-btn" class="hidden">
                    <button type="button"
                        class="mt-2 p-2 bg-emerald-500 rounded-md text-white hover:bg-emerald-600 flex items-center justify-center"
                        onclick="addOption()">
                        @svg('mdi-plus', 'w-5 h-5 mr-1')
                        @lang('messages.addOption')</button>
                </div>
                <div class="flex justify-end gap-2 mt-6">
                    <!-- Cancel Button -->
                    <a href="{{ route('question.index') }}"
                        class="bg-slate-500 px-4 py-2 rounded-md h-9 text-white hover:bg-slate-700 flex items-center transition-colors duration-150">
                        @svg('mdi-arrow-left', 'w-5 h-5 mr-1')
                        @lang('messages.back')
                    </a>
                    <!-- Submit Button -->
                    <button type="submit"
                        class="inline-flex items-center justify-center h-9 w-9 text-white bg-indigo-500 hover:bg-indigo-700 rounded-md border border-transparent focus:outline-none transition-colors duration-150"
                        id="submit-btn" title="@lang('messages.submit')">
                        @svg('mdi-check', 'w-5 h-5')
                    </button>
                </div>
            </form>
        </div>
    </div>
    @vite('resources/js/questionEdit.js')
</x-app-layout>
