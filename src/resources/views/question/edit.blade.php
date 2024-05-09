<x-app-layout>
    <div class="question-container single-question">
        <h1>Edit you note</h1>
        <form action="{{ route('question.update', $question)}}" method="POST" class="question">
            @csrf
            @method('PUT')
            <textarea name="question" cols="30" rows="10" class="question-body" placeholder="Enter your question">{{ $question->question}}</textarea>
            <div class="question-buttons">
                <a href="{{ route('question.index')}}" class="question-cancel-button">Cancel</a>
                <button class="question-submit-button">Submit</button>
            </div>
        </form>
    </div>
</x-app-layout>
