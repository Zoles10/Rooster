<x-app-layout>
    <div class="bg-white min-h-screen flex flex-col items-center justify-center text-white">
        <div
            class="imp_margin_04 max-w-xl w-full p-6 md:p-8 bg-gray-100 rounded-lg shadow-lg shadow-gray-400 text-black">
            <h1 class="text-2xl font-bold mb-5 text-center text-black">@lang('messages.createQuestion')</h1>
            <form id="main-form" method="POST" action="{{ route('question.store') }}"
                class="bg-gray-100 p-4 rounded-lg text-black">
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
                <div id="add-option-btn" class="hidden flex justify-center">
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
                        class="bg-slate-500 px-4 py-2 rounded-md text-white h-9 hover:bg-slate-700 flex items-center transition-colors duration-150">
                        @svg('mdi-arrow-left', 'w-5 h-5 mr-1')
                        @lang('messages.back')
                    </a>
                    <!-- Submit Button -->
                    <button type="submit"
                        class="inline-flex items-center justify-center h-9 w-9 text-white bg-indigo-500 hover:bg-indigo-700 rounded-md border border-transparent focus:outline-none transition-colors duration-150"
                        id="submit-btn" title="@lang('messages.createQuestion')">
                        @svg('mdi-check', 'w-5 h-5')
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        window.LangMessages = {
            correct: "@lang('messages.correct')",
            optionText: "@lang('messages.optionText')",
            enterQue: "@lang('messages.enterQue')",
            enterSubjectName: "@lang('messages.enterSubjectName')",
            atLeastOneOption: "At least one option is required.",
            optionTextEmpty: "Option text is empty.",
            atLeastOneCorrect: "At least one option must be marked as correct."
        };
    </script>
    @vite('resources/js/questionCreate.js')
</x-app-layout>
