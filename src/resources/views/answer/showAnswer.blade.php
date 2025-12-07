<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('messages.results') }}
        </h2>
    </x-slot>
    @php
        $question = \App\Models\Question::find($question_id);
    @endphp

    <div class="bg-white min-h-screen pt-5 flex flex-col items-center text-white">
        <div class="imp_margin_04 max-w-7xl w-full text-black">
            <div class="p-6 md:p-8">
                <!-- Mobile view -->
                <div id="mobileTable" class="grid grid-cols-1 gap-4 py-6 px-4 sm:px-6 lg:px-8 lg:hidden">
                    <!-- content injected by JS via Ajax (same as table rows) -->
                </div>
                <div class="overflow-x-auto w-full hidden lg:block">
                    <div class="py-2 align-middle inline-block min-w-full">
                        <div class="shadow-lg overflow-hidden border-b border-gray-200 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200 mb-2">
                                <thead class="imp_bg_white p-2">
                                    <tr>
                                        <th
                                            class="px-6 py-4 text-left text-m font-medium text-gray-800 uppercase tracking-wider">
                                            {{ __('messages.user') }}
                                        </th>
                                        <th
                                            class="px-6 py-4 text-left text-m font-medium text-gray-800 uppercase tracking-wider">
                                            {{ __('messages.option_text') }}
                                        </th>
                                        <th
                                            class="px-6 py-4 text-left text-m font-medium text-gray-800 uppercase tracking-wider">
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
                        class="px-4 py-2 bg-slate-500 text-white rounded-md hover:bg-slate-700 flex items-center h-9 transition-colors duration-150">
                        @svg('mdi-arrow-left', 'w-5 h-5 mr-1')
                        @lang('messages.back')
                    </a>
                    @if (Auth::check() && Auth::id() === $question->owner_id && $question->options()->whereHas('answers')->exists())
                        <form action="{{ route('answers.export', $question->id) }}" method="GET"
                            class="mb-2 md:mb-0 md:ml-2">
                            <button type="submit"
                                class="px-4 py-2  text-white rounded-md bg-teal-400 hover:bg-teal-600 h-9 transition-colors duration-150 flex items-center">
                                @svg('mdi-file-export', 'w-5 h-5 mr-1')
                                @lang('messages.export')
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile bottom actions (back + export) -->
    <div class="px-4 sm:px-6 lg:hidden mt-4">
        <div class="flex justify-center gap-2">
            <a href="{{ Auth::check() && Auth::id() === $question->owner_id ? route('questions') : route('welcome') }}"
                class="px-4 py-2 bg-slate-500 text-white rounded-md hover:bg-slate-700 flex items-center h-9 transition-colors duration-150">
                @svg('mdi-arrow-left', 'w-5 h-5 mr-1')
                @lang('messages.back')
            </a>

            @if (Auth::check() && Auth::id() === $question->owner_id && $question->options()->whereHas('answers')->exists())
                <form action="{{ route('answers.export', $question->id) }}" method="GET">
                    <button type="submit"
                        class="px-4 py-2  text-white rounded-md bg-teal-400 hover:bg-teal-600 h-9 transition-colors duration-150 flex items-center">
                        @svg('mdi-file-export', 'w-5 h-5 mr-1')
                        @lang('messages.export')
                    </button>
                </form>
            @endif
        </div>
    </div>

    <!-- Mobile bottom actions (back + export) -->
    <div class="px-4 sm:px-6 lg:hidden mt-4">
        <div class="flex justify-center gap-2">
            <a href="{{ Auth::check() && Auth::id() === $question->owner_id ? route('questions') : route('welcome') }}"
                class="px-4 py-2 bg-slate-500 text-white rounded-md hover:bg-slate-700 flex items-center">
                @svg('mdi-arrow-left', 'w-5 h-5 mr-1')
                @lang('messages.back')
            </a>

            @if (Auth::check() && Auth::id() === $question->owner_id && $question->options()->whereHas('answers')->exists())
                <form action="{{ route('answers.export', $question->id) }}" method="GET">
                    <button type="submit"
                        class="px-4 py-2  text-white rounded-md bg-teal-400 hover:bg-teal-600  flex items-center">
                        @svg('mdi-file-export', 'w-5 h-5 mr-1')
                        @lang('messages.export')
                    </button>
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
