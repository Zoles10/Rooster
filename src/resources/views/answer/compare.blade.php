<x-app-layout>
    <div class="flex flex-wrap -mx-4">
        <div class="w-full md:w-1/2 px-4">
            <h1 class="text-2xl font-semibold mb-4">{{ __('messages.actualAnswers') }}</h1>
            <div class="overflow-x-auto bg-white shadow-md rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            @if ($question->question_type == 'multiple_choice')
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('messages.option_text') }}</th>
                            @else
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('messages.answer_text') }}</th>
                            @endif
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('messages.timesAnswered') }}</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @if ($question->question_type == 'multiple_choice')
                            @foreach ($question->options as $option)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $option->option_text }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $option->optionsHistory()->times_answered }}</td>
                                </tr>
                            @endforeach
                        @else
                            @foreach ($answers->unique('user_text') as $answer)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $answer->user_text }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ \App\Models\Answer::where('user_text', $answer->user_text)->where('question_id', $question->id)->where('archived', false)->count() }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        <div class="w-full md:w-1/2 px-4">
            <h1 class="text-2xl font-semibold mb-4">{{ __('messages.archivedAnswers') }}</h1>
            <div class="overflow-x-auto bg-white shadow-md rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            @if ($question->question_type == 'multiple_choice')
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('messages.option_text') }}</th>
                            @else
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('messages.answer_text') }}</th>
                            @endif
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('messages.timesAnswered') }}</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @if ($question->question_type == 'multiple_choice')
                            @foreach ($archivedAnswers as $history)
                                @php
                                $option = \App\Models\Option::find($history->option_id);
                                @endphp
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $option->option_text }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $history->times_answered }}</td>
                                </tr>
                            @endforeach
                        @else
                            @foreach ($archivedAnswers->unique('user_text') as $answer)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $answer->user_text }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ \App\Models\Answer::where('user_text', $answer->user_text)->where('question_id', $question->id)->count() }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
