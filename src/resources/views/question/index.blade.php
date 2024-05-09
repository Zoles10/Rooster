<x-app-layout>
    <div class ="question-container">
        <a href="{{ route('question.create')}}" class="new-question-btn">
            Create question
        </a>
        <table class="table table-striped min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Question
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($questions as $question)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="{{ route('question.show', $question->id) }}" class="text-sm text-gray-900">
                                {{ $question->question }}
                            </a>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <a href="{{ route('question.edit', $question->id) }}" class="btn btn-secondary">Edit</a>
                            <form action="{{ route('question.destroy', $question->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <form action="{{ route('question.destroy', $question) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="question-delete-button">Delete</button>
                                </form>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $questions->links()}}
    </div>
</x-app-layout>
