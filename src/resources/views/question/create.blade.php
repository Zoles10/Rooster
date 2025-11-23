<x-app-layout>
    <div class="bg-white min-h-screen flex flex-col items-center pt-5 text-white">
        <div class="imp_margin_04 max-w-xl w-full bg-gray-100 rounded-md shadow-lg shadow-gray-400 text-black">
            <div class="imp_bg_white w-full px-6 md:px-8 py-4 rounded-t-lg">
                <h1 class="text-2xl font-bold text-center text-black">@lang('messages.createQuestion')</h1>
            </div>
            <form id="main-form" method="POST" action="{{ route('question.store') }}" class="p-6 md:p-8 text-black">
                @csrf
                <div class="mb-4">
                    <label for="question" class="block text-sm font-medium text-black">@lang('messages.question'):</label>
                    <span id="question-err" class="imp_invalid_input_text" style="display: none;"></span>
                    <input type="text"
                        class="form-control mt-1 block w-full px-3 py-2 text-black bg-white border border-gray-600 rounded-md shadow-sm focus:outline-none focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        id="question" name="question" placeholder="@lang('messages.enterQuestion')">
                </div>
                @if (auth()->user()->isAdmin())
                    <div class="mb-4">
                        <label for="ownerInput" class="block text-sm font-medium text-black">@lang('messages.user'):</label>
                        <select
                            class="form-control mt-1 block text-black w-full px-3 py-2 bg-white border border-gray-600 rounded-md shadow-sm focus:outline-none focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            id="ownerInput" name="ownerInput">
                            <option value="" selected disabled>@lang('messages.selectUser')</option>
                            @foreach ($users as $user)
                                @if (auth()->user()->name == $user->name)
                                    <option value="{{ $user->name }}"
                                        @if (auth()->user()->name == $user->name) selected @endif>{{ $user->name }}</option>
                                @else
                                    <option value="{{ $user->name }}">{{ $user->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                @endif
                <!-- Subject Dropdown -->
                <div class="mb-4">
                    <label for="subject" class="block text-sm font-medium text-black">@lang('messages.subject')</label>
                    <span id="subject-err" class="imp_invalid_input_text" style="display: none;"></span>
                    <select id="subject" name="subject"
                        class="text-black form-control mt-1 block w-full px-3 py-2 border border-gray-600 rounded-md shadow-sm focus:outline-none focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @foreach ($subjects as $subject)
                            <option value="{{ $subject->id }}">{{ $subject->subject }}</option>
                        @endforeach
                        <option value="0">@lang('messages.other')</option>
                    </select>
                </div>

                <!-- Additional Input Field (Initially Hidden) -->
                <div id="other-subject-container" class="hidden mt-4">
                    <label for="other-subject" class="block text-sm font-medium text-black">@lang('messages.specifySubjectName')</label>
                    <span id="othersubject-err" class="imp_invalid_input_text" style="display: none;"></span>
                    <input type="text" id="other-subject" name="other_subject" placeholder="@lang('messages.subjectName')"
                        class="form-control text-black mt-1 block w-full px-3 py-2 bg-white border border-gray-600 rounded-md shadow-sm focus:outline-none focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>

                <div id="options-container" class="mb-4 mt-4">

                </div>
                <span id="option-err" class="imp_invalid_input_text" style="display: none;"></span>
                <!-- Add Option Button with Inline Styles -->
                <div id="add-option-btn" class="flex justify-center">
                    <button type="button"
                        class="mt-2 p-2 bg-emerald-500 rounded-md text-white hover:bg-emerald-600 flex items-center justify-center"
                        onclick="addOption()">
                        @svg('mdi-plus', 'w-5 h-5 mr-1')
                        @lang('messages.addOption')
                    </button>
                </div>

                <div class="flex justify-end gap-2 mt-4">
                    <!-- Back Button -->
                    <a href="{{ route('question.index') }}"
                        class="bg-slate-500 px-4 py-2 rounded-md text-white hover:bg-slate-700 flex items-center transition-colors duration-150">
                        @svg('mdi-arrow-left', 'w-5 h-5 mr-1')
                        @lang('messages.back')
                    </a>
                    <!-- Submit Button -->
                    <button type="submit"
                        class="inline-flex items-center justify-center px-4 py-2 bg-indigo-500 hover:bg-indigo-600 text-white rounded-md border border-transparent focus:outline-none transition ease-in-out duration-150">
                        @svg('mdi-content-save', 'w-5 h-5 mr-2')
                        @lang('messages.submit')
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        window.LangMessages = {
            correct: "@lang('messages.correct')",
            optionText: "@lang('messages.optionText')",
            enterQue: "@lang('messages.questionTextRequired')",
            enterSubjectName: "@lang('messages.enterSubjectName')",
            atLeastOneOption: "@lang('messages.atLeastOneOption')",
            optionTextEmpty: "@lang('messages.optionTextEmpty')",
            atLeastOneCorrect: "@lang('messages.atLeastOneCorrect')"
        };
    </script>
    @vite('resources/js/questionCreate.js')
</x-app-layout>
