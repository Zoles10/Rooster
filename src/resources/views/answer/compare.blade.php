<x-app-layout>
    <div class="row">
        <div class="col-md-6">
            <h1>{{__('messages.actualAnswers')}}</h1>
            <table>
                <thead>
                    @if ($question->question_type == 'multiple_choice')
                    <tr>
                        <th>{{__('messages.option_text')}}</th>
                    @else
                        <th>{{__('messages.answer_text')}}</th>
                    @endif
                        <th>{{__('messages.timesAnswered')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($question->question_type == 'multiple_choice')
                        @foreach ($question->options() as $option)
                            <tr>
                                <td>{{ $option->option_text }}</td>
                                <td>{{ $option->optionsHistory()->times_answered }}</td>
                            </tr>
                        @endforeach
                    @else
                        @foreach ($answers->unique('user_text') as $answer)
                            @if ($answer->archived == 0)
                                    <td>{{ $answer->user_text }}</td>
                                    <td>{{ \App\Models\Answer::where('user_text', $answer->user_text)->where('question_id', $question->id)->where('archived', false)->count() }}</td>
                                </tr>
                            @endif
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
        <div class="col-md-6">
            <h1>{{__('messages.archivedAnswers')}}</h1>
            <table>
                <thead>
                    @if ($question->question_type == 'multiple_choice')
                    <tr>
                        <th>{{__('messages.option_text')}}</th>
                    @else
                        <th>{{__('messages.answer_text')}}</th>
                    @endif
                        <th>{{__('messages.timesAnswered')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($question->question_type == 'multiple_choice')
                        @foreach ($question->options() as $option)
                            @php
                                $optionsHistory = \App\Models\OptionsHistory::where('option_id', $option->id)->where('archived', true)->get();
                            @endphp
                            @foreach ($optionsHistory as $history)
                                <tr>
                                    <td>{{ $option->option_text }}</td>
                                    <td></td>{{ $history->times_answered }}</td>
                                </tr>
                            @endforeach
                        @endforeach
                    @else
                        @foreach ($answers->unique('user_text') as $answer)
                            @if ($answer->archived == 1)
                                <tr>
                                    <td>{{ $answer->user_text }}</td>
                                    <td>{{ \App\Models\Answer::where('user_text', $answer->user_text)->where('question_id', $question->id)->where('archived', true)->count() }}</td>
                                </tr>
                            @endif
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
