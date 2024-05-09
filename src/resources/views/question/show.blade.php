<x-app-layout>
    <div class="question-container single-ton">
        <div class="question-header">
            <h1>Question: {{ $question->created_at}}</h1>
            <div class="question-buttons">
                <a href="{{ route('question.edit', $question)}}" class="question-edit-button">Edit</a>
                <form action="{{ route('question.destroy', $question) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="question-delete-button">Delete</button>
                </form>
            </div>
        </div>
        <div class="question">
            <div class="question-body">
                {{ $question->question}}
            </div>
        </div>
    </div>
</x-app-layout>
