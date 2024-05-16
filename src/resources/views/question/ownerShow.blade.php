<div>
    <h2 class="text-xl mb-3">@lang('messages.ownerVisible')</h2>
    @if ($question->active == 0)
        <form method="POST" action="{{ route('question.update', $question) }}" class="my-2">
            @csrf
            @method('PUT')
            <input type="hidden" name="active" value="1">
            <button type="submit" class="my-2 mr-2 px-4 py-2 bg-blue-500 rounded-md text-white hover:bg-blue-600">@lang('messages.activate')</button>
        </form>
    @else
        <form method="POST" action="{{ route('question.update', $question) }}" class="my-2">
            @csrf
            @method('PUT')
            <input type="hidden" name="active" value="0">
            <button type="submit" class="my-2 mr-2 px-4 py-2 bg-blue-500 rounded-md text-white hover:bg-blue-600">@lang('messages.deactivate')</button>
        </form>
    @endif
    <div class="my-2">
        <a href="{{ route('question.edit', $question->id) }}" type="submit" class="my-2 mr-2 px-4 py-2 bg-green-500 rounded-md text-white hover:bg-green-600">@lang('messages.edit')</a>
    </div>
    <form action="{{ route('question.destroy', $question->id) }}" method="POST" class="my-2">
        @csrf
        @method('DELETE')
        <button type="submit" class="my-2 mr-2 px-4 py-2 bg-red-500 rounded-md text-white hover:bg-red-600">@lang('messages.delete')</button>
    </form>
    <form action="{{ route('question.multiply', $question) }}" method="POST" class="my-2">
        @csrf
        @method('POST')
        <button type="submit" class="my-2 mr-2 px-4 py-2 bg-purple-500 rounded-md text-white hover:bg-purple-600">@lang('messages.clone')</button>
    </form>
</div>
