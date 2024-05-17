<div class="flex flex-col items-center">
    <h2 class="text-xl mb-3">@lang('messages.ownerVisible')</h2>
    <div class="flex justify-center space-x-2 my-2">
        <form method="POST" action="{{ route('question.update', $question) }}" class="flex items-center">
            @csrf
            @method('PUT')
            <input type="hidden" name="active" value="{{ $question->active ? '0' : '1' }}">
            <input type="checkbox" name="active_checkbox"
                class="form-checkbox h-5 w-5 text-indigo-600 rounded"
                onchange="this.form.submit()" value="{{ $question->id }}"
                {{ $question->active ? 'checked' : '' }}>
            <label class="text-sm text-gray-700 ml-2">{{ $question->active ? __('messages.deactivate') : __('messages.activate') }}</label>
            @if ($question->active)
                <input type="text" name="note" class="ml-2 px-2 py-1 border border-gray-300 rounded-md" placeholder="@lang('messages.note')">
            @else
                <div class="ml-2 text-sm text-gray-700">
                    <div>{{ __('messages.lastClosed') }}: {{ \Carbon\Carbon::parse($question->last_closed)->format('d.m.Y') }}</div>
                    <div>{{ __('messages.lastNote') }}: {{ $question->last_note }}</div>
                </div>
            @endif
        </form>
        <a href="{{ route('question.edit', $question->id) }}" class="px-4 py-2 bg-green-500 rounded-md text-white hover:bg-green-600">@lang('messages.edit')</a>
        <form action="{{ route('question.destroy', $question->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="px-4 py-2 bg-red-500 rounded-md text-white hover:bg-red-600">@lang('messages.delete')</button>
        </form>
        <form action="{{ route('question.multiply', $question) }}" method="POST">
            @csrf
            @method('POST')
            <button type="submit" class="px-4 py-2 bg-purple-500 rounded-md text-white hover:bg-purple-600">@lang('messages.clone')</button>
        </form>
    </div>
</div>
