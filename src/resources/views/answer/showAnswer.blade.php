<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('messages.results') }}
        </h2>
    </x-slot>
    @php
        $question = \App\Models\Question::find($question_id);
    @endphp
    <!-- Mobile view -->
    <div id="mobileTable" class="grid grid-cols-1 gap-4 py-6 px-4 sm:px-6 lg:px-8 lg:hidden">
        <!-- content injected by JS via Ajax (same as table rows) -->
    </div>
    <div class="py-12 hidden lg:block">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hidden lg:block">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto hidden lg:block">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('messages.user') }}
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('messages.option_text') }}
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('messages.correct') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="multiple-choice-tbody" class="bg-white divide-y divide-gray-200">
                                <!-- Data will be appended here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Back Button (desktop only) -->
            <div class="hidden lg:flex justify-center mt-4">
                @php
                    $question = \App\Models\Question::find($question_id);
                @endphp
                <a href="{{ Auth::check() && Auth::id() === $question->owner_id ? route('questions') : route('welcome') }}"
                    class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                    @lang('messages.back')
                </a>
                @if (Auth::check() && Auth::id() === $question->owner_id && $question->options()->whereHas('answers')->exists())
                    <form action="{{ route('answers.export', $question->id) }}" method="GET"
                        class="mb-2 md:mb-0 md:ml-2">
                        <button type="submit"
                            class="px-4 py-2 bg-blue-500 rounded-md text-white hover:bg-blue-600">@lang('messages.export')</button>
                    </form>
                @endif
            </div>
        </div>
    </div>

    <!-- Mobile bottom actions (back + export) -->
    <div class="px-4 sm:px-6 lg:hidden mt-4">
        <div class="flex justify-center gap-2">
            <a href="{{ Auth::check() && Auth::id() === $question->owner_id ? route('questions') : route('welcome') }}"
                class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">@lang('messages.back')</a>

            @if (Auth::check() && Auth::id() === $question->owner_id && $question->options()->whereHas('answers')->exists())
                <form action="{{ route('answers.export', $question->id) }}" method="GET">
                    <button type="submit"
                        class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">@lang('messages.export')</button>
                </form>
            @endif
        </div>
    </div>

    <script>
        window.answersShowConfig = {
            updateUrl: "{{ route('answers.showUpdate', ['question' => $question_id]) }}",
            isOwner: {{ Auth::check() && Auth::id() === $question->owner_id ? 'true' : 'false' }},
            exportUrl: "{{ route('answers.export', $question->id) }}",
            noResults: "{{ __('messages.noResults') }}",
            exportLabel: "{{ __('messages.export') }}",
            updateInterval: 5000,
        };
    </script>
    @vite('resources/js/answersShow.js')
</x-app-layout>
