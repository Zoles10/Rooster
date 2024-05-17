<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('messages.results') }}
        </h2>
    </x-slot>
    @php
        $question = \App\Models\Question::find($question_id);
        $question = \App\Models\Question::with(['options.optionsHistory'])->find($question_id);
    @endphp
    <style>
        html, body, #container {
            width: 100%;
            height: 800px;
            margin: 0;
            padding: 0;
        }
    </style>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if($question->question_type == 'open_ended')
                @if($question->word_cloud == 0)
                    <!-- Display table with answers -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                {{ __('messages.answer_text') }}
                                            </th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                {{ __('messages.number') }}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="open-ended-tbody" class="bg-white divide-y divide-gray-200">
                                        <!-- Data will be appended here -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @elseif($question->word_cloud == 1)
                    <!-- Display wordcloud -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900" id='container'></div>
                    </div>
                @endif
            @elseif($question->question_type == 'multiple_choice')
                <!-- Display table with options history -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __('messages.option_text') }}
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __('messages.number') }}
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
            @endif
            <!-- Back Button -->
            <div class="flex justify-center mt-4">
                <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                    @lang('messages.back')
                </a>
            </div>
        </div>
    </div>
    <script src="https://cdn.anychart.com/releases/v8/js/anychart-base.min.js"></script>
    <script src="https://cdn.anychart.com/releases/v8/js/anychart-tag-cloud.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        @if($question->question_type == 'multiple_choice')
        // call the 'show' method from the 'AnswerController' to update 'answerCounts'
        function updateTable() {
            $.ajax({
                url: '/question/{{ $question_id }}/answers/update',
                method: 'GET',
                success: function(response) {
                // update the 'answerCounts' variable with the updated data
                var answerCounts = response;
                // clear the table
                $('#multiple-choice-tbody').empty();
                // update the table with the updated data
                for (var key in answerCounts) {
                    var item = answerCounts[key];
                    $('#multiple-choice-tbody').append('<tr><td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">' + key + '</td><td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">' + item + '</td></tr>');
                }
                },
                error: function(error) {
                console.log(error);
                }
            });
        }

        // update the table initially
        updateTable();

        // refresh the table every 2 seconds
        setInterval(updateTable, 2000);
        @else
            @if($question->word_cloud == true)
            anychart.onDocumentReady(function() {
                // create a tag (word) cloud chart
                var chart = anychart.tagCloud();

                // call the 'show' method from the 'AnswerController' to update 'answerCounts'
                function updateChart() {
                $.ajax({
                    url: '/question/{{ $question_id }}/answers/update',
                    method: 'GET',
                    success: function(response) {
                    // update the 'answerCounts' variable with the updated data
                    var answerCounts = response;
                    // convert the answerCounts array to the desired pattern
                    var formattedData = [];
                    for (var item in answerCounts) {
                        formattedData.push({ "x": item, "value": answerCounts[item] });
                    }

                    chart.data(formattedData);
                    // set a chart title
                    chart.title('{{ __('messages.answer_text') }} {{ $question->question }}')
                    // set an array of angles at which the words will be laid out
                    chart.angles([0])
                    chart.container("container");
                    chart.draw();
                    },
                    error: function(error) {
                    console.log(error);
                    }
                });
                }

                // update the chart initially
                updateChart();

                // refresh the chart every 2 seconds
                setInterval(updateChart, 2000);
            });
            @else
            // call the 'show' method from the 'AnswerController' to update 'answerCounts'
            function updateTable() {
                $.ajax({
                    url: '/question/{{ $question_id }}/answers/update',
                    method: 'GET',
                    success: function(response) {
                    // update the 'answerCounts' variable with the updated data
                    var answerCounts = response;
                    // clear the table
                    $('#open-ended-tbody').empty();
                    // update the table with the updated data
                    for (var item in answerCounts) {
                        $('#open-ended-tbody').append('<tr><td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">' + item + '</td><td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">' + answerCounts[item] + '</td></tr>');
                    }
                    },
                    error: function(error) {
                    console.log(error);
                    }
                });
            }

            // update the table initially
            updateTable();

            // refresh the table every 2 seconds
            setInterval(updateTable, 2000);
            @endif
        @endif
    </script>
</x-app-layout>
