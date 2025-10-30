<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('messages.results') }}
        </h2>
    </x-slot>
    @php
        $question = \App\Models\Question::find($question_id);
    @endphp
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto">
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
            <!-- Back Button -->
            <div class="flex justify-center mt-4">
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
    <script src="https://cdn.anychart.com/releases/v8/js/anychart-base.min.js"></script>
    <script src="https://cdn.anychart.com/releases/v8/js/anychart-tag-cloud.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function updateTable() {
            $.ajax({
                url: '/question/{{ $question_id }}/answers/update',
                method: 'GET',
                success: function(response) {
                    var answerCounts = response;
                    $('#multiple-choice-tbody').empty();
                    answerCounts.forEach(function(item) {
                        var correctIcon = item.correct ? '✓' : '✗';
                        var correctClass = item.correct ? 'text-green-600' : 'text-red-600';
                        $('#multiple-choice-tbody').append(
                            '<tr>' +
                            '<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">' + item
                            .user_name + '</td>' +
                            '<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">' + item
                            .selected_option + '</td>' +
                            '<td class="px-6 py-4 whitespace-nowrap text-sm font-medium ' +
                            correctClass + '">' + correctIcon + '</td>' +
                            '</tr>'
                        );
                    });
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }
        updateTable();
        setInterval(updateTable, 5000);
    </script>
</x-app-layout>
