<x-app-layout>
    <div class="bg-white min-h-screen flex flex-col items-center justify-center text-white">
        <div class="imp_margin_04 max-w-xl w-full p-6 md:p-8 bg-gray-500 rounded-lg shadow-lg shadow-gray-400">
            <h1 class="text-2xl font-bold mb-5 text-center">@lang('messages.createQuiz')</h1>
            <form id="main-form" method="POST" action="{{ route('quiz.store') }}" class="bg-gray-500 p-4 rounded-lg">
                @csrf
                <div class="mb-4">
                    <label for="quiz" class="block text-sm font-medium text-white">@lang('messages.quiz'):</label>
                    <span id="quiz-err" class="imp_invalid_input_text" style="display: none;"></span>
                    <input type="text"
                        class="form-control mt-1 block w-full px-3 py-2 text-black bg-white border border-gray-600 rounded-md shadow-sm focus:outline-none focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        id="quiz" name="quiz" placeholder="@lang('messages.enterQuiz')">
                </div>
                @csrf
                <div class="mb-4">
                    <label for="quizDescription" class="block text-sm font-medium text-white">@lang('messages.quizDescription'):</label>
                    <span id="quiz-err" class="imp_invalid_input_text" style="display: none;"></span>
                    <input type="text"
                        class="form-control mt-1 block w-full px-3 py-2 text-black bg-white border border-gray-600 rounded-md shadow-sm focus:outline-none focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        id="quizDescription" name="quizDescription" placeholder="@lang('messages.enterQuizDescription')">
                </div>
                @if (auth()->user()->isAdmin())
                    <div class="mb-4">
                        <label for="ownerInput" class="block text-sm font-medium text-white">@lang('messages.user'):</label>
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
                <div class="flex justify-between mt-4">
                    <!-- Cancel Button -->
                    <div class="bg-blue-700 px-4 py-2 rounded-md text-white hover:bg-gray-600">
                        <a href={{ route('quizzes') }}>@lang('messages.backToQuizzes')</a>
                    </div>
                    <!-- Submit Button -->
                    <button type="submit" class="px-4 py-2 imp_bg_purple rounded-md text-white"
                        id="submit-btn">@lang('messages.submit')</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
