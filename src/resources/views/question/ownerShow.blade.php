<div class="flex flex-col items-center p-4 md:p-6 lg:p-8">
    <h2 class="text-xl mb-3">@lang('messages.ownerVisible')</h2>
    <div class="flex flex-col md:flex-row md:justify-center md:space-x-2 my-2 w-full md:w-auto items-center">
        <form method="POST" action="{{ route('question.update', $question) }}"
            class="flex flex-col md:flex-row items-center mb-2 md:mb-0 w-full md:w-auto">
            @csrf
            @method('PUT')
            <input type="hidden" name="active" value="{{ $question->active ? '0' : '1' }}">
            <input type="checkbox" name="active_checkbox" id='toggleQuestion'
                class="form-checkbox h-5 w-5 text-indigo-600 rounded" onchange="this.form.submit()"
                value="{{ $question->id }}" {{ $question->active ? 'checked' : '' }}>
            <label
                class="text-sm text-gray-700 ml-2">{{ $question->active ? __('messages.deactivate') : __('messages.activate') }}</label>
            @if (!$question->active)
                <div class="ml-2 text-sm text-gray-700 mt-2 md:mt-0">
                    <div>{{ __('messages.lastClosed') }}:
                        {{ \Carbon\Carbon::parse($question->last_closed)->format('d.m.Y') }}</div>
                </div>
            @endif
        </form>
        <a href="/questions"
            class="inline-block px-4 py-2 bg-blue-500 rounded-md text-white hover:bg-blue-600">@lang('messages.back')</a>
        <a href="{{ route('question.edit', $question->id) }}"
            class="px-4 py-2 bg-green-500 rounded-md text-white hover:bg-green-600 mb-2 md:mb-0 md:ml-2">@lang('messages.edit')</a>
        <form action="{{ route('question.destroy', $question->id) }}" method="POST" class="mb-2 md:mb-0 md:ml-2">
            @csrf
            @method('DELETE')
            <button type="submit"
                class="px-4 py-2 bg-red-500 rounded-md text-white hover:bg-red-600">@lang('messages.delete')</button>
        </form>
        <form action="{{ route('question.multiply', $question) }}" method="POST" class="mb-2 md:mb-0 md:ml-2">
            @csrf
            @method('POST')
            <button type="submit"
                class="px-4 py-2 bg-purple-500 rounded-md text-white hover:bg-purple-600">@lang('messages.clone')</button>
        </form>
    </div>
</div>
