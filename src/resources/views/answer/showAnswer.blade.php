<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Results') }}
        </h2>
    </x-slot>
    @php
        $id = request()->route('question');
        $question = \App\Models\Question::find($id);
        $question = \App\Models\Question::with(['options.optionsHistory'])->find($id);
    @endphp
    <style>
        html, body, #container {
        width: 100%;
        height: 800px;
        margin: 0;
        padding: 0;
        }
    </style>
    @if($question->question_type == 'open_ended')
        @if($question->word_cloud == 0)
            <!-- Display table with answers -->
            <table>
                <thead>
                    <tr>
                        <th>Answer Text</th>
                        <th>Number</th>
                    </tr>
                </thead>
                <tbody>
                    <h1>answers table here</h1>
                    {{-- @foreach($answers as $answer)
                        <tr>
                            <td>{{ $answer->text }}</td>
                            <td>{{ $answer->number }}</td>
                        </tr>
                    @endforeach --}}
                </tbody>
            </table>
        @elseif($question->word_cloud == 1)
            <!-- Display wordcloud -->
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white  overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 " id='container'>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @elseif($question->question_type == 'multiple_choice')
        <!-- Display table with options history -->
        <table>
            <thead>
                <tr>
                    <th>Option Text</th>
                    <th>Number</th>
                </tr>
            </thead>
            <tbody>
                <h1>options table here</h1>
                @foreach($question->options as $index => $option)
                    <tr>
                        <td>{{ $option->option_text }}</td>
                        <td>{{ $option->optionsHistory->times_answered }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    <script src="https://cdn.anychart.com/releases/v8/js/anychart-base.min.js"></script>
    <script src="https://cdn.anychart.com/releases/v8/js/anychart-tag-cloud.min.js"></script>
    <script>

        anychart.onDocumentReady(function() {
            var data = [
                @foreach($answerCounts as $index => $count)
                    {"x": "{{ $index }}", "value": {{ $count }}},
                @endforeach
            ];

            // create a tag (word) cloud chart
            var chart = anychart.tagCloud(data);

            // set a chart title
            chart.title('answers for {{ $question->question }}')
            // set an array of angles at which the words will be laid out
            chart.angles([0])
            // enable a color range
            // chart.colorRange(true);
            // set the color range length
            // chart.colorRange().length('80%');

            // display the word cloud chart
            chart.container("container");
            chart.draw();
        });
    </script>
</x-app-layout>
